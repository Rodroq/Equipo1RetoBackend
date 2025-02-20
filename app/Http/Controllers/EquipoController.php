<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Middleware\CanRecoverToken;
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
            //seguridad para la autenticación del ususario
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware(CanRecoverToken::class, only: ['index', 'show']),

            //seguridad para las rutas de update y destroy SI YA TIENE CREADO UN EQUIPO
            new Middleware('role:administrador|entrenador', only: ['update', 'destroy']),
            new Middleware('permission:editar_equipo|borrar_equipo', only: ['update', 'destroy']),

            //seguridad para la ruta store a traves de rol y permisos SOLO SI NO SE TIENE CREADO YA UN EQUIPO
            new Middleware('role:entrenador', only: ['store']),
            new Middleware('permission:crear_equipo', only: ['store']),
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
     *  security={"bearerAuth"},
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
        //si se es administrador se pueden visualizar todos los equipos, aunque no esten aprobados
        if ($this->user && $this->user->hasRole('administrador')) {
            $equipos = Equipo::with('jugadores', 'centro')->get();
        } else {
            $equipos = Equipo::whereHas('inscripciones', function ($query) {
                $query->where('estado', 'aprobada');
            })->with('jugadores', 'centro')->get();
        }

        if ($equipos->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No hay equipos'
            ], 200);
        }


        return response()->json([
            'success' => true,
            'message' => 'Equipos disponibles',
            'equipos' => EquipoResource::collection($equipos)
        ], 200);
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
        //si se es administrador se pueden visualizar el equipo en concreto, aunque no esten aprobados
        /* $equipo = Equipo::find($equipo);
        if ($this->user && $this->user->hasRole('administrador')) {
            $equipo = Equipo::find($equipo);
        } else {
            $equipo = Equipo::whereHas('inscripciones', function ($query) use ($equipo) {
                $query->where('equipo_id', $equipo->id);
            })->with('jugadores', 'centro')->get();
        }
         */
        $equipo = Equipo::find($equipo);
        if ($equipo->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Equipo encontrado',
            'equipo' => new EquipoResource($equipo)
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
        if ($request->centro) {
            $centro_id = Centro::where('nombre', $request->centro)->first()->id;
        }

        $equipo = Equipo::create([
            'nombre' => $request->nombre,
            'grupo' => $request->grupo,
            'centro_id' => $centro_id ?? null,
        ]);

        //llamar a la funcion para crear todos los jugadores de un equipo
        $equipo->crearJugadores($request->jugadores);

        //eliminar en el usuario el permiso de poder crear un equipo
        $this->user->revokePermissionTo('crear_equipo');
        //agregar en el usuario el permiso de poder editar y borrar un equipo
        $this->user->givePermissionTo(['editar_equipo', 'borrar_equipo', 'crear_jugador', 'borrar_jugador', 'editar_jugador']);

        $this->user->deleteTokens();

        $id_equipo = $equipo->id;
        $abilities = ["editar_equipo_{$id_equipo}", "borrar_equipo_{$id_equipo}","crear_jugador_equipo_{$id_equipo}" ,"actualizar_jugador_equipo_{$id_equipo}", "borrar_jugador_equipo_{$id_equipo}"];
        $newToken = $this->user->createToken('token_usuario', $abilities)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Equipo creado correctamente',
            'equipo' => new EquipoResource($equipo),
            'token' => $newToken
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
    public function update(ActualizarEquipoRequest $request, $equipo)
    {
        $equipo = Equipo::find($equipo);

        if (!$equipo) {
            return response()->json([
                'success' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        }

        if ($this->user->tokenCant("editar_equipo_{$equipo->id}")) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para actualizar este equipo',
            ], 403);
        }

        $equipo->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Equipo actualizado correctamente',
            'equipo' => new EquipoResource($equipo)
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
    public function destroy($equipo)
    {
        $equipo = Equipo::find($equipo);

        if (!$equipo) {
            return response()->json([
                'success' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        }

        if ($this->user->tokenCant("borrar_equipo_{$equipo->id}")) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para borrar este equipo',
            ], 403);
        }

        $equipo->delete();
        //agregar en el usuario el permiso de poder crear un equipo
        $this->user->givePermissionTo('crear_equipo');
        //eliminar en el usuario el permiso de poder editar y borrar un equipo
        $this->user->revokePermissionTo(['editar_equipo', 'borrar_equipo', 'crear_jugador', 'borrar_jugador', 'editar_jugador']);

        return response()->json([
            'success' => true,
            'message' => 'Equipo eliminado correctamente'
        ], 200);
    }
}
