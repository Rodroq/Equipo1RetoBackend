<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CanRecoverToken;
use App\Http\Requests\ActualizarEquipoRequest;
use App\Http\Requests\CrearEquipoRequest;
use App\Http\Resources\EquipoResource;
use App\Models\{Centro, Equipo};
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class EquipoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            //seguridad para la autenticación del ususario
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware(CanRecoverToken::class, only: ['index']),
            //seguridad para las rutas de update y destroy SI YA TIENE CREADO UN EQUIPO
            new Middleware('role:administrador|entrenador', only: ['update', 'destroy']),
            //seguridad para la ruta store a traves de rol y permisos SOLO SI NO SE TIENE CREADO YA UN EQUIPO
            new Middleware('role:entrenador', only: ['store']),
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
        $esAdmin = $this->user && $this->servicio_autenticacion->userHasRole($this->user, 'administrador');
        //si se es administrador se pueden visualizar todos los equipos, aunque no esten aprobados
        if ($esAdmin) {
            $equipos = Equipo::with('jugadores', 'centro')->get();
        } else {
            $equipos = Equipo::whereHas('inscripciones', function ($query) {
                $query->where('estado', 'aprobada');
            })->with('jugadores', 'centro')->get();
        }

        if ($equipos->isEmpty()) {
            return response()->json(['success' => true, 'message' => 'No hay equipos'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Equipos disponibles', 'equipos' => EquipoResource::collection($equipos)], 200);
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
    public function show(Equipo $equipo)
    {
        return response()->json(['success' => true, 'message' => 'Equipo encontrado', 'equipo' => new EquipoResource($equipo)], 200);
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
     *  security={"bearerAuth"},
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
     *  @OA\Response(
     *      response=403,
     *      description="Prohibido",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes para crear un nuevo equipo. Revisa si ya creaste uno")
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
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="Prohibido",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permiso para editar este equipo")
     *      )
     *  ),
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
     *      response=403,
     *      description="Prohibido",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permiso para borrar este equipo")
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
