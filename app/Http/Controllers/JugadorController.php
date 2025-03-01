<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarJugadorRequest;
use App\Http\Requests\CrearJugadorRequest;
use App\Http\Resources\JugadorDetalleResource;
use App\Http\Resources\JugadorResource;
use App\Models\{Ciclo, Estudio, Equipo, Jugador};
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class JugadorController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware('role:administrador|entrenador', only: ['update', 'destroy']),
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
     *              @OA\Property(property="imagen", type="object",
     *                  @OA\Property(property="url", type="string"),
     *                  @OA\Property(property="nombre", type="string", example="1-nombre")
     *              ),
     *          ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay jugadores"
     *  ),
     * )
     */
    public function index()
    {
        $jugadores = Jugador::with('estudio')->get();

        if ($jugadores->isEmpty()) {
            return response()->json(status: 204);
        }

        return response()->json(['success' => true, 'message' => 'Jugadores disponibles', 'jugadores' => JugadorResource::collection($jugadores),], 200);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/jugadores/{slug}",
     *  summary="Obtener un jugador",
     *  description="Obtener un jugador por su Slug",
     *  operationId="showJugador",
     *  tags={"jugadores"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del jugador",
     *      required=true,
     *      @OA\Schema(type="slug",example="samuel-tamayo-muniz")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="jugador encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugador encontrado"),
     *          @OA\Property(property="jugador", type="object", ref="#/components/schemas/Jugador"),
     *      ),
     * ),
     *  @OA\Response(
     *      response=404,
     *      description="Recurso no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Jugador no encontrado")
     *       ),
     *  ),
     * )
     */
    public function show(Jugador $jugador)
    {
        return response()->json(['success' => true, 'message' => 'Jugador encontrado', 'jugador' => new JugadorDetalleResource($jugador)], 200);
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
     *  security={{"bearerAuth": {}}},
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
     *  @OA\Response(
     *      response=401,
     *      description="No autorizado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Debes iniciar sesión para acceder a este recurso")
     *      )
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="Prohibido",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permisos para realizar esta accion")
     *      )
     *  ),
     * )
     */
    public function store(CrearJugadorRequest $request)
    {
        $response = Gate::inspect('create', [Jugador::class, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $equipo = Equipo::where('usuarioIdCreacion', $this->user->id)->firstOrFail();

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
        ]);

        if ($equipo->jugadores()->count() === 12) {
            $this->user->revokePermissionTo('crear_jugador');
        }

        return response()->json(['success' => true, 'message' => 'Jugador creado correctamente', 'jugador' => new JugadorDetalleResource($jugador)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *  path="/api/jugadores/{slug}",
     *  summary="Actualizar un jugador",
     *  description="Actualizar un jugador por su Slug",
     *  operationId="updateJugador",
     *  security={{"bearerAuth": {}}},
     *  tags={"jugadores"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del jugador",
     *      required=true,
     *      @OA\Schema(type="string",example="samuel-tamayo-muniz")
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
     *      response=401,
     *      description="No autorizado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Debes iniciar sesión para acceder a este recurso")
     *      )
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="Prohibido",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permisos para realizar esta accion | No tienes permisos para editar ningún jugador de {equipo} | No puedes editar el jugador samuel-tamayo-muniz del equipo Desguace FC"),
     *          @OA\Property(property="code", type="string", example="JUGADOR_EDIT_FORBIDDEN")
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Recurso no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="El recurso solicitado no fue encontrado")
     *      )
     *  )
     * )
     */
    public function update(ActualizarJugadorRequest $request, Jugador $jugador)
    {
        $response = Gate::inspect('update', [$jugador, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        //Obtener estudio al que pertenece el jugador a través del ciclo al que pertenece, si es que se especificó
        if ($request->ciclo) {
            $ciclo_id = Ciclo::where('nombre', $request->ciclo)->first()->id;
            $estudio_id = Estudio::where('ciclo_id', $ciclo_id)->first()->id;
            $jugador->estudio_id = $estudio_id;
        }

        $jugador->update($request->only([
            'nombre',
            'apellido1',
            'apellido2',
            'tipo',
            'dni',
            'email',
            'telefono',
        ]));

        return response()->json(['success' => true, 'message' => 'jugador actualizado correctamente', 'jugador' => new JugadorDetalleResource($jugador)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/jugadores/{slug}",
     *  summary="Eliminar un jugador",
     *  description="Eliminar un jugador por su Slug",
     *  operationId="deleteJugador",
     *  security={{"bearerAuth": {}}},
     *  tags={"jugadores"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del jugador",
     *      required=true,
     *      @OA\Schema(type="string",example="samuel-tamayo-muniz")
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
     *      response=401,
     *      description="No autorizado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Debes iniciar sesión para acceder a este recurso")
     *      )
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="Prohibido",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permisos para borar ningún jugador | No puedes borrar el jugador samuel-tamayo-muniz del equipo Desguace FC"),
     *          @OA\Property(property="code", type="string", example="JUGADOR_DELETE_FORBIDDEN")
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Recurso no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="El recurso solicitado no fue encontrado")
     *      )
     *  )
     * )
     */
    public function destroy(Jugador $jugador)
    {
        $response = Gate::inspect('delete', [$jugador, $this->user]);

        if (!$response->allowed()) return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());

        $jugador->delete();

        $this->user->givePermissionTo('crear_jugador');

        return response()->json(['success' => true, 'message' => 'Jugador eliminado correctamente'], 200);
    }
}
