<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarInscripcionEquipoRequest;
use App\Http\Resources\InscripcionResource;
use App\Mail\InscripcionTorneo;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};
use Illuminate\Support\Facades\Mail;

class InscripcionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
            new Middleware('role:administrador'),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/inscripciones",
     *  summary="Obtener todos las inscripciones de equipos",
     *  description="Obtener todos las inscripciones de equipos ordenadas segun su estado actual en la web",
     *  operationId="indexInscripciones",
     *  security={{"bearerAuth": {}}},
     *  tags={"inscripciones"},
     *  @OA\Response(
     *      response=200,
     *      description="Inscripciones encontradas",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Inscripciones encontradas"),
     *          @OA\Property(property="inscripciones", type="array", @OA\Items(ref="#/components/schemas/Inscripcion"))
     *      )
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay inscripciones"
     *  )
     *  )
     */
    public function index()
    {
        $inscripciones = Inscripcion::all()->groupBy('estado');
        if ($inscripciones->isEmpty()) {
            return response()->json(status: 204);
        }

        $inscripcionesAgrupadas = $inscripciones->map(function ($grupo) {
            return InscripcionResource::collection($grupo);
        });
        return response()->json(['success' => true, 'message' => 'Inscripciones disponibles', 'inscripciones' => $inscripcionesAgrupadas], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *  path="/api/inscipciones/{slug}",
     *  summary="Actualizar la inscripcion de un equipo",
     *  description="Actualizar la inscripcion de un equipo en la web",
     *  operationId="updateInscripcion",
     *  security={{"bearerAuth": {}}},
     *  tags={"inscripciones"},
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
     *          @OA\Property(property="comentario", type="string"),
     *          @OA\Property(property="estado", type="string", example="[pendiente | rechazada | aprobada]"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=201,
     *     description="Inscripcion del equipo actualizada correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Inscripcion del equipo actualizada correctamente"),
     *          @OA\Property(property="inscripciones", type="array", @OA\Items(ref="#/components/schemas/Inscripcion")),
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
     *          @OA\Property(property="message", type="string", example="No tienes permisos para realizar esta accion."),
     *          @OA\Property(property="code", type="string", example="EQUIPO_EDIT_FORBIDDEN"),
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Recurso no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="El recurso solicitado no fue encontrado.")
     *      )
     *  )
     *)
     */
    public function update(ActualizarInscripcionEquipoRequest $request, Inscripcion $inscripcion)
    {
        $inscripcion->update($request->all());
        $estado = $inscripcion->estado;

        $mensaje = "
        Su equipo ha sido {$estado} de nuestro torneo solidario<br/>
        ";

        $usuario = User::where('id',$inscripcion->usuarioIdCreacion)->first();
        Mail::to($usuario->email)->send(new InscripcionTorneo($usuario, $mensaje));


        return response()->json(['success' => true, 'message' => 'Inscripcion actualizada correctamente', 'inscripcion' => new InscripcionResource($inscripcion)], 200);
    }
}
