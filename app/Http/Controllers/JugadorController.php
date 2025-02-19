<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\Middleware;
use App\Http\Middleware\CanRecoverToken;
use App\Http\Requests\ActualizarJugadorRequest;
use App\Http\Requests\CrearJugadorRequest;
use App\Http\Resources\JugadorDetalleResource;
use App\Http\Resources\JugadorResource;
use App\Models\Ciclo;
use App\Models\Equipo;
use App\Models\Estudio;
use App\Models\Jugador;

class JugadorController extends Controller
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware(CanRecoverToken::class, only: ['index', 'show']),
            new Middleware('role:administrador|entrenador', except: ['index', 'show']),
            new Middleware('role:entrenador', only: ['store']),
        ];
    }
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
     *          @OA\Property(
     *              property="jugador",
     *              type="object",
     *              @OA\Property(property="nombre", type="string", example="Nombre"),
     *              @OA\Property(property="apellido1", type="string", example="Apellido 1"),
     *              @OA\Property(property="apellido2", type="string", example="Apellido 2"),
     *              @OA\Property(property="tipo", type="string", example="[jugador|capitan|entrenador]"),
     *          ),
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
                'jugadores' => JugadorResource::collection($jugadores),
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
     *          @OA\Property(property="data", type="jugador", ref="#/components/schemas/Jugador"),
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
            'success' => true,
            'message' => 'Jugador encontrado',
            'jugador' => new JugadorDetalleResource($jugador)
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
     *          @OA\Property(property="jugador", type="array", @OA\Items(ref="#/components/schemas/Jugador")),
     *     ),
     *  ),
     * )
     */
    public function store(CrearJugadorRequest $request)
    {
        if ($this->user->tokenCant('crear_jugador')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para crear un nuevo jugador en este equipo',
            ], 403);
        }

        $equipo = Equipo::where('nombre', $request->equipo)->first();

        //impedir crear jugador si el cupo ya esta lleno
        if (!$equipo->canCreateJugador()){
            return response()->json([
                'success' => true,
                'message' => 'Equipo lleno',
            ]);
        }

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
            'equipo_id' => $equipo->id,
            'estudio_id' => $estudio_id ?? null,
            /* Este campo se tendra que eliminar y realizar el agregado a través del modelo con la autenticacion de usuarios */
            'usuarioIdCreacion' => $request->usuarioIdCreacion
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jugador creado correctamente',
            'jugador' => new JugadorDetalleResource($jugador)
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
     *          @OA\Property(property="jugador", type="array", @OA\Items(ref="#/components/schemas/Jugador")),
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
        if ($request->equipo) {
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
            'jugador' => new JugadorDetalleResource($jugador)
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
            return response()->json([
                'success' => false,
                'message' => 'Jugador no encontrado'
            ], 404);
        }

        $jugador->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jugador eliminado correctamente'
        ], 200);
    }
}
