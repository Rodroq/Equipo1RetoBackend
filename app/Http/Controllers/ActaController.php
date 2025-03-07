<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarActaRequest;
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
            new Middleware('role:administrador', only: ['update', 'destroy']),
            new Middleware('role:director', only: ['store']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/actas",
     *  summary="Obtener todas las actas de la web",
     *  description="Obtener todas las actas en la llamada a la API",
     *  operationId="indexActas",
     *  security={{"bearerAuth": {}}},
     *  tags={"actas"},
     *  @OA\Response(
     *      response=200,
     *      description="Actas disponibles",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Actas disponibles"),
     *          @OA\Property(
     *              property="actas",
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Acta"))
     *          ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay actas"
     *  )
     *)
     */
    public function index()
    {
        $actas = $this->user->hasRole('director') ? Acta::where('usuarioIdCreacion', $this->user->id)->get() : Acta::all();

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

        $partido = Partido::where('slug', $request->partido)->firstOrFail();
        $jugador = Jugador::where('slug', $request->jugador)->firstOrFail();

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
     *  path="/api/actas/{slug}",
     *  summary="Actualizar una acta",
     *  description="Actualizar una acta por su Slug",
     *  operationId="updateActa",
     *  security={{"bearerAuth": {}}},
     *  tags={"actas"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug de la acta",
     *      required=true,
     *      @OA\Schema(type="slug")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos de la acta",
     *      @OA\JsonContent(
     *          @OA\Property(property="incidencia", type="string", example="goles"),
     *          @OA\Property(property="comentario", type="integer"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=201,
     *     description="Acta actualizada correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Acta actualizado correctamente"),
     *          @OA\Property(property="acta", type="array", @OA\Items(ref="#/components/schemas/Acta")),
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
     *          @OA\Property(property="message", type="string", example="No tienes permisos para editar ninguna acta | No puedes editar la acta"),
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
    public function update(ActualizarActaRequest $request, Acta $acta)
    {
        $response = Gate::inspect('update', [$acta, $this->user]);
        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $acta->update($request->all());

        return response()->json(['success' => true, 'message' => 'Acta actualizada correctamente', 'equipo' => new ActaResource($acta)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/actas/{slug}",
     *  summary="Eliminar una acta",
     *  description="Eliminar una acta por su Slug",
     *  operationId="deleteActa",
     *  security={{"bearerAuth": {}}},
     *  tags={"actas"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug de la acta",
     *   required=true,
     *   @OA\Schema(type="string")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Acta eliminada correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Acta eliminada correctamente")
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
     *          @OA\Property(property="message", type="string", example="No tienes permisos para borrar ninguna acta | No puedes borrar la acta"),
     *          @OA\Property(property="code", type="string", example="ACTA_DELETE_FORBIDDEN")
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
    public function destroy(Acta $acta)
    {
        $response = Gate::inspect('delete', [$acta, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $acta->delete();

        return response()->json(['success' => true, 'message' => 'Acta eliminada correctamente'], 200);
    }
}
