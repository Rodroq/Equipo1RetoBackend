<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearActaRequest;
use App\Http\Resources\ActaResource;
use App\Models\{Acta, Jugador, Partido};
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};
use Illuminate\Support\Facades\Gate;

class ActaController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
            new Middleware('role:administrador|director', only: ['update', 'destroy']),
            new Middleware('role:director', only: ['store']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/equipos",
     *  summary="Obtener todos las acas de la web",
     *  description="Obtener todas las actas en la llamada a la API",
     *  operationId="indexActas",
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
        $this->user->hasRole('director') ? $actas = Acta::where('usuarioIdCreacion', $this->user->id)->get() : Acta::all();

        if ($actas->isEmpty()) {
            return response()->json(status: 204);
        }

        return response()->json(['success' => true, 'message' => 'Actas disponibles', 'actas' => ActaResource::collection($actas)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearActaRequest $request, Acta $acta)
    {
        $response = Gate::inspect('store', [$acta, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $partido = Partido::where('slug', $request->partido)->first();
        $jugador = Jugador::where('slug', $request->jugador)->first();

        if ($partido->equipoLoc->id !== $jugador->equipo_id && $partido->equipoVis->id !== $jugador->equipo_id) {
            return response()->json(['success' => false, 'message' => "El jugador {$jugador->nombre} no esta participando en este partido"], 409);
        }

        $acta = Acta::create([
            'partido_id' => $partido->id,
            'jugador_id' => $jugador->id,
            'incidencia' => $request->incidencia,
            'hora' => date('H:i:s'),
            'comentario' => $request->comentario
        ]);

        $nuevo_token = $this->servicio_autenticacion->generateUserToken($this->user);

        return response()->json(['success' => true, 'message' => 'Acta creada correctamente', 'acta' => new ActaResource($acta), 'token' => $nuevo_token], 200);
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
