<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarJugadorRequest;
use App\Http\Requests\CrearJugadorRequest;
use App\Http\Resources\JugadorResource;
use App\Models\Ciclo;
use App\Models\Equipo;
use App\Models\Estudio;
use App\Models\Jugador;

class JugadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/jugadores",
     *  summary="Obtener todos los jugadores de la web",
     *  description="Obtener todos los jugadores en la llamada a la API",
     *  operationId="indexJugadores",
     *  tags={"jugadores"},
     *  @OA\Response(
     *      response=200,
     *      description="Jugadores disponibles",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugadores disponibles"),
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Jugador")),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay jugadores",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No hay jugadores")
     *       ),
     *  ),
     * )
     */
    public function index()
    {
        $jugadores = Jugador::with('estudio')->get();

        if ($jugadores->isEmpty()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No hay jugadores'
                ],
                204
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Jugadores disponibles',
                'data' => ['jugadores' => JugadorResource::collection($jugadores)],
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/jugadores/{id}",
     *  summary="Obtener un jugador",
     *  description="Obtener un jugador por su id",
     *  operationId="showJugador",
     *  tags={"jugadores"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del jugador",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="jugador encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugador encontrado"),
     *          @OA\Property(property="data", type="object", ref="#/components/schemas/Jugador"),
     *      ),
     * ),
     *  @OA\Response(
     *      response=404,
     *      description="Jugador no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Jugador no encontrado")
     *       ),
     *  ),
     * )
     */
    public function show($jugador)
    {
        $jugador = Jugador::find($jugador);

        if (!$jugador) {
            return response()->json([
                'success' => false,
                'message' => 'Jugador no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Jugador encontrado',
            'data' => new JugadorResource($jugador)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/jugadores",
     *  summary="Crear un nuevo jugador",
     *  description="Crear un nuevo jugador",
     *  operationId="storeJugador",
     *  tags={"jugadores"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del jugador",
     *      @OA\JsonContent(
     *          required={"nombre"},
     *          @OA\Property(property="nombre", type="string", example="Jugador 1"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="jugador creado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugador creado correctamente"),
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Jugador")),
     *     ),
     *  ),
     * )
     */
    public function store(CrearJugadorRequest $request)
    {
        $request->validated();

        //Obtener equipo al que pertenece el jugador
        $equipo_id = Equipo::where('nombre', $request->equipo)->first()->id;

        //Obtener estudio al que pertenece el jugador a través del ciclo al que pertenece, si es que se especificó
        if ($request->ciclo) {
            $ciclo_id = Ciclo::select('id')->where('nombre', $request->ciclo)->first()->id;
            $estudio_id = Estudio::where('ciclo_id', $ciclo_id)->first()->id;
        }

        $jugador = Jugador::create([
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'tipo' => $request->tipo,
            'dni' => $request->dni,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'equipo_id' => $equipo_id,
            'estudio_id' => $estudio_id ?? null,
            /* Este campo se tendra que eliminar y realizar el agregado a través del modelo con la autenticacion de usuarios */
            'usuarioIdCreacion' => $request->usuarioIdCreacion
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jugador creado correctamente',
            'data' => ['jugador' => new JugadorResource($jugador)]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *  path="/api/jugadores/{id}",
     *  summary="Actualizar un jugador",
     *  description="Actualizar un jugador",
     *  operationId="updateJugador",
     *  tags={"jugadores"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del jugador",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del jugador",
     *      @OA\JsonContent(
     *          @OA\Property(property="nombre", type="string", example="Jugador 1"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=201,
     *     description="Jugador actualizado correctamente",
     *     @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugador actualizado correctamente"),
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Jugador")),
     *     ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Jugador no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Jugador no encontrado")
     *       ),
     *  ),
     * )
     */
    public function update(ActualizarJugadorRequest $request, $jugador)
    {
        //Actualizar tambien las imagenes
        $jugador = jugador::find($jugador);

        // Verificar si el jugador existe
        if (!$jugador) {
            return response()->json([
                'success' => false,
                'message' => 'Jugador no encontrado'
            ], 404);
        }

        //probar a ver si se pueden borrar por usar el failedValidation function en los request
        $request->validated();

        //Actualizar el equipo al que pertenece el jugador
        if($request->equipo){
            $equipo_id = Equipo::where('nombre', $request->equipo)->first()->id;
            $jugador->equipo_id = $equipo_id;
        }

        //Obtener estudio al que pertenece el jugador a través del ciclo al que pertenece, si es que se especificó
        if ($request->ciclo) {
            $ciclo_id = Ciclo::where('nombre', $request->ciclo)->first()->id;
            $estudio_id = Estudio::where('ciclo_id', $ciclo_id)->first()->id;
            $jugador->estudio_id = $estudio_id;
        }


        // Si la validación pasa, se procede a actualizar
        $jugador->update($request->only([
            'nombre',
            'apellido1',
            'apellido2',
            'tipo',
            'dni',
            'email',
            'telefono',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'jugador actualizado correctamente',
            'data' => ['jugador' => new JugadorResource($jugador)]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/jugadores/{id}",
     *  summary="Eliminar un jugador",
     *  description="Eliminar un jugador por su id",
     *  operationId="deleteJugador",
     *  tags={"jugadores"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del jugador",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Jugador eliminado correctamente",
     *       @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugador eliminado correctamente")
     *       )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Jugador no encontrado",
     *       @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Jugador no encontrado")
     *       )
     *  ),
     * ),
     */
    public function destroy($jugador)
    {
        $jugador = Jugador::find($jugador);

        if (!$jugador) {
            return response()->json(['success' => false, 'message' => 'Jugador no encontrado'], 404);
        }

        $jugador->delete();

        return response()->json(['success' => true, 'message' => 'Jugador eliminado correctamente'], 200);
    }
}
