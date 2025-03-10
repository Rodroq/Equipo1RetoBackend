<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearPatrocinadorRequest;
use App\Http\Resources\{PatrocinadorDetalleResource, PatrocinadorResource};
use App\Models\Equipo;
use App\Models\Patrocinador;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};
use Illuminate\Support\Facades\Gate;

class PatrocinadorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware('role:administrador|entrenador', only: ['store','destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/aptrocinadores",
     *  summary="Obtener todos los patrocinadores de la web",
     *  description="Obtener todos los patrocinadores en la llamada a la API",
     *  operationId="indexPatrocinadores",
     *  tags={"patrocinadores"},
     *  @OA\Response(
     *      response=200,
     *      description="Patrocinadores encontrados",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Patrocinadores encontrados"),
     *          @OA\Property(
     *              property="patrocinadores",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="nombre", type="string", example="Nombre"),
     *                  @OA\Property(property="equipo", type="string", example="desguace-fc"),
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
     *      description="No hay patrocinadores"
     *  )
     *)
     */
    public function index()
    {
        $patrocinadores = Patrocinador::all();

        if ($patrocinadores->isEmpty()) {
            return response()->json(status: 204);
        }

        return response()->json(['success' => true, 'message' => 'Patrocinadores disponibles', 'patrocinadores' => PatrocinadorResource::collection($patrocinadores)], 200);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/patrocinadores/{slug}",
     *  summary="Obtener un patrocinador",
     *  description="Obtener un patrocinador por su Slug",
     *  operationId="showPatrocinador",
     *  tags={"patrocinadores"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del patrocinador",
     *      required=true,
     *      @OA\Schema(type="string")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Patrocinador disponibles",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Patrocinador disponible"),
     *          @OA\Property(property="patrocinador", type="array", @OA\Items(ref="#/components/schemas/Patrocinador")),
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
    public function show(Patrocinador $patrocinador)
    {
        return response()->json(['success' => true, 'message' => 'Patrocinador encontrado', 'patrocinador' => new PatrocinadorDetalleResource($patrocinador)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/patrocinador",
     *  summary="Crear un patrocinador",
     *  description="Crear un patrocinador",
     *  operationId="storePatrocinador",
     *  security={{"bearerAuth": {}}},
     *  tags={"patrocinadores"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del patrocinador",
     *      @OA\JsonContent(
     *          required={"nombre","equipo"},
     *          @OA\Property(property="nombre", type="string"),
     *          @OA\Property(property="equipo", type="string", example="desguace-fc"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Patrocinador creado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Patrocinador creado correctamente"),
     *          @OA\Property(property="patrocinador", type="object", ref="#/components/schemas/Patrocinador"),
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
    public function store(CrearPatrocinadorRequest $request)
    {
        $equipo = Equipo::where('slug', $request->equipo)->first();
        $response = Gate::inspect('create', [Patrocinador::class, $equipo->id]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $patrocinador = Patrocinador::create($request->except('equipo'));

        $patrocinador->equipos()->syncWithoutDetaching($equipo);

        return response()->json(['success' => true, 'message' => 'Patrocinador creado correctamente', 'patrocinador' => new PatrocinadorDetalleResource($patrocinador)], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/patrocinadores/{slug}",
     *  summary="Eliminar un patrocinador",
     *  description="Eliminar un patrocinador por su Slug",
     *  operationId="deletePatrocinador",
     *  security={{"bearerAuth": {}}},
     *  tags={"patrocinadores"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del patrocinador",
     *   required=true,
     *   @OA\Schema(type="string")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Patrocinador eliminado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Patrocinador eliminado correctamente")
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
     *          @OA\Property(property="message", type="string", example="No tienes permisos para borrar ningún patrocinador | No puedes borrar el patrocinador de este equipo"),
     *          @OA\Property(property="code", type="string", example="PATROCINADOR_DELETE_FORBIDDEN")
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
    public function destroy(Patrocinador $patrocinador)
    {
        $response = Gate::inspect('delete', [$patrocinador]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $patrocinador->delete();

        $nuevo_token = $this->servicio_autenticacion->generateUserToken($this->user);

        return response()->json(['success' => true, 'message' => 'Patrocionador eliminado correctamente', 'token' => $nuevo_token], 200);
    }
}
