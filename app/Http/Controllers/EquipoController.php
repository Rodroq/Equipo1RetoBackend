<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\ActualizarEquipoRequest;
use App\Http\Requests\CrearEquipoRequest;
use App\Http\Resources\EquipoResource;
use App\Models\Centro;
use App\Models\Ciclo;
use App\Models\Equipo;
use App\Models\Estudio;

class EquipoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:administrator|coach', except: ['index', 'show']),
            new Middleware('role:coach', only: ['create']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/equipos",
     *  summary="Obtener todos los equipos de la web",
     *  description="Obtener todos los equipos en la llamada a la API",
     *  operationId="indexEquipos",
     *  tags={"equipos"},
     *  @OA\Response(
     *      response=200,
     *      description="Equipo disponibles",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipos disponibles"),
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Equipo")),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay equipos encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No hay equipos")
     *      )
     *  )
     *)
     */
    public function index()
    {
        $equipos = Equipo::with('jugadores', 'centro')->get();

        if ($equipos->isEmpty()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No hay equipos'
                ],
                204
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Equipos disponibles',
                'data' => ['equipos' => EquipoResource::collection($equipos)],
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/equipos/{id}",
     *  summary="Obtener un equipo",
     *  description="Obtener un equipo por su id",
     *  operationId="showEquipo",
     *  tags={"equipos"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del equipo",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Equipo encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipo encontrado"),
     *          @OA\Property(property="data", type="object", ref="#/components/schemas/Equipo"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Equipo no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Equipo no encontrado")
     *      )
     *  )
     *)
     */
    public function show($equipo)
    {
        $equipo = Equipo::find($equipo);
        if (!$equipo) {
            return response()->json([
                'status' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Equipo encontrado',
            'data' => new EquipoResource($equipo)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/equipos",
     *  summary="Crear un equipo con sus jugadores",
     *  description="Crear un equipo con sus jugadores",
     *  operationId="storeEquipo",
     *  tags={"equipos"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del equipo",
     *      @OA\JsonContent(
     *          required={"nombre","jugadores"},
     *          @OA\Property(property="nombre", type="string", example="Equipo 1"),
     *          @OA\Property(property="centro_id", type="integer", example="1"),
     *          @OA\Property(
     *              property="jugadores",
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Jugador"),
     *          ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Equipo creado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipo creado correctamente"),
     *          @OA\Property(property="data", type="object", ref="#/components/schemas/Equipo"),
     *      ),
     *  ),
     *)
     */
    public function store(CrearEquipoRequest $request)
    {
        $request->validated();

        //Obtener centro al que pertenece el equipo
        $centro_id = Centro::where('nombre', $request->centro)->first()->id;

        $equipo = Equipo::create([
            'nombre' => $request->nombre,
            'grupo' => $request->grupo,
            'centro_id' => $centro_id,
            /* Este campo se tendra que eliminar y realizar el agregado a través del modelo con la autenticacion de usuarios */
            'usuarioIdCreacion' => $request->usuarioIdCreacion
        ]);

        $equipo->jugadores()->createMany(
            collect($request->jugadores)->map(function ($jugador) {
                if (!array_key_exists('ciclo', $jugador)) {
                    return $jugador;
                }
                $ciclo_id = Ciclo::where('nombre', $jugador['ciclo'])->first()->id;
                $estudio_id = Estudio::where('ciclo_id', $ciclo_id)->first()->id;
                $jugador['estudio_id'] = $estudio_id;
                return $jugador;
            })
        );

        return response()->json([
            'status' => true,
            'message' => 'Equipo creado correctamente',
            'data' => new EquipoResource($equipo)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *  path="/api/equipos/{id}",
     *  summary="Actualizar un equipo",
     *  description="Actualizar un equipo",
     *  operationId="updateEquipo",
     *  tags={"equipos"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del equipo",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del equipo",
     *      @OA\JsonContent(
     *          @OA\Property(property="nombre", type="string", example="Equipo 1"),
     *          @OA\Property(property="centro_id", type="integer", example="1"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=201,
     *     description="Equipo actualizado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipo actualizado correctamente"),
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Equipo")),
     *     ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Equipo no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Equipo no encontrado")
     *      )
     *  )
     *)
     */
    public function update(ActualizarEquipoRequest $request, $equipo)
    {
        $equipo = Equipo::find($equipo);

        // Verificar si el equipo existe
        if (!$equipo) {
            return response()->json([
                'success' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        }

        // Si la validación pasa, se procede a actualizar
        $equipo->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Equipo actualizado correctamente',
            'data' => ['equipo' => new EquipoResource($equipo)]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/equipos/{id}",
     *  summary="Eliminar un equipo",
     *  description="Eliminar un equipo por su id",
     *  operationId="deleteEquipo",
     *  tags={"equipos"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del equipo",
     *   required=true,
     *   @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Equipo eliminado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipo eliminado correctamente")
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Equipo no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Equipo no encontrado")
     *      )
     *  )
     * ),
     */
    public function destroy($equipo)
    {
        $equipo = Equipo::find($equipo);

        if (!$equipo) {
            return response()->json([
                'success' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        }

        $equipo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Equipo eliminado correctamente'
        ], 200);
    }
}
