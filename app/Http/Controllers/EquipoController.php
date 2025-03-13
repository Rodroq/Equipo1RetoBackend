<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CanRecoverToken;
use App\Http\Requests\ActualizarEquipoRequest;
use App\Http\Requests\CrearEquipoRequest;
use App\Http\Resources\EquipoDetalleResource;
use App\Http\Resources\EquipoResource;
use App\Models\{Centro, Equipo, Inscripcion};
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class EquipoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware(CanRecoverToken::class, only: ['index']),
            new Middleware('role:administrador|entrenador', only: ['store','update', 'destroy']),
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
     *  security={{"bearerAuth": {}}},
     *  tags={"equipos"},
     *  @OA\Response(
     *      response=200,
     *      description="Equipos encontrados",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipos encontrados"),
     *          @OA\Property(
     *              property="equipos",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="nombre", type="string", example="Nombre"),
     *                  @OA\Property(property="slug", type="string", example="nombre-1"),
     *                  @OA\Property(property="centro", type="object",
     *                      @OA\Property(property="nombre", type="string", example="nombre")
     *                  ),
     *                  @OA\Property(property="imagen", type="object",
     *                      @OA\Property(property="url", type="string"),
     *                      @OA\Property(property="nombre", type="string", example="1-nombre")
     *                  ),
     *              )
     *          ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay equipos"
     *  )
     *)
     */
    public function index()
    {
        $esAdmin = $this->user && $this->servicio_autenticacion->userHasRole($this->user, 'administrador');

        if ($esAdmin) {
            $equipos = Equipo::with('jugadores', 'centro')->get();
        } else {
            $equipos = Equipo::whereHas('inscripciones', function ($query) {
                $query->where('estado', 'aprobada');
            })->with('jugadores', 'centro')->get();
        }

        if ($equipos->isEmpty()) {
            return response()->json(status: 204);
        }

        return response()->json(['success' => true, 'message' => 'Equipos disponibles', 'equipos' => EquipoResource::collection($equipos)], 200);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/equipos/{slug}",
     *  summary="Obtener un equipo",
     *  description="Obtener un equipo por su Slug",
     *  operationId="showEquipo",
     *  tags={"equipos"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del equipo",
     *      required=true,
     *      @OA\Schema(type="string",example="desguace-fc")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Equipo disponibles",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipos disponibles"),
     *          @OA\Property(property="equipo", type="array", @OA\Items(ref="#/components/schemas/Equipo")),
     *      ),
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
     *)
     */
    public function show(Equipo $equipo)
    {
        return response()->json(['success' => true, 'message' => 'Equipo encontrado', 'equipo' => new EquipoDetalleResource($equipo)], 200);
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
     *  security={{"bearerAuth": {}}},
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
     *          @OA\Property(property="equipo", type="object", ref="#/components/schemas/Equipo"),
     *      ),
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
     *)
     */
    public function store(CrearEquipoRequest $request)
    {
        $response = Gate::inspect('create', [Equipo::class, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $centro_id = $request->centro ? Centro::where('nombre', $request->centro)->first()->id : null;

        $equipo = Equipo::create(['nombre' => $request->nombre, 'grupo' => $request->grupo, 'centro_id' => $centro_id,]);

        Inscripcion::create([
            'equipo_id' => $equipo->id,
            'estado' => 'pendiente',
            'comentarios' => 'Esperando la aceptacion al torneo',
        ]);

        $equipo->crearJugadores($request->jugadores);

        $this->user->syncPermissions(['editar_equipo', 'borrar_equipo', 'borrar_jugador', 'editar_jugador']);

        if ($equipo->jugadores()->count() < 12) {
            $this->user->givePermissionTo('crear_jugador');
        }

        $nuevo_token = $this->servicio_autenticacion->generateUserToken($this->user);

        return response()->json(['success' => true, 'message' => 'Equipo creado correctamente', 'equipo' => new EquipoResource($equipo), 'token' => $nuevo_token], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *  path="/api/equipos/{slug}",
     *  summary="Actualizar un equipo",
     *  description="Actualizar un equipo por su Slug",
     *  operationId="updateEquipo",
     *  security={{"bearerAuth": {}}},
     *  tags={"equipos"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del equipo",
     *      required=true,
     *      @OA\Schema(type="slug",example="desguace-fc")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del equipo",
     *      @OA\JsonContent(
     *          @OA\Property(property="nombre", type="string", example="Equipo 1"),
     *          @OA\Property(property="grupo", type="integer", example="A"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=201,
     *     description="Equipo actualizado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipo actualizado correctamente"),
     *          @OA\Property(property="equipo", type="array", @OA\Items(ref="#/components/schemas/Equipo")),
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
     *          @OA\Property(property="message", type="string", example="No tienes permisos para editar ningún equipo | No puedes editar el equipo Desguace FC"),
     *          @OA\Property(property="code", type="string", example="EQUIPO_EDIT_FORBIDDEN"),
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
     *)
     */
    public function update(ActualizarEquipoRequest $request, Equipo $equipo)
    {
        $response = Gate::inspect('update', [$equipo, $this->user]);
        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $equipo->update($request->all());

        return response()->json(['success' => true, 'message' => 'Equipo actualizado correctamente', 'equipo' => new EquipoResource($equipo)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/equipos/{slug}",
     *  summary="Eliminar un equipo",
     *  description="Eliminar un equipo por su Slug",
     *  operationId="deleteEquipo",
     *  security={{"bearerAuth": {}}},
     *  tags={"equipos"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del equipo",
     *   required=true,
     *   @OA\Schema(type="string",example="desguace-fc")
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
     *          @OA\Property(property="message", type="string", example="No tienes permisos para borrar ningún equipo | No puedes borrar el equipo Desguace FC"),
     *          @OA\Property(property="code", type="string", example="EQUIPO_DELETE_FORBIDDEN")
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
    public function destroy(Equipo $equipo)
    {
        $response = Gate::inspect('delete', [$equipo, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $equipo->delete();

        $this->user->syncPermissions(['crear_equipo']);
        $nuevo_token = $this->servicio_autenticacion->generateUserToken($this->user);

        return response()->json(['success' => true, 'message' => 'Equipo eliminado correctamente', 'token' => $nuevo_token], 200);
    }
}
