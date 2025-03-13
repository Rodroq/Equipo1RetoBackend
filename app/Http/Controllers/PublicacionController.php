<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarPublicacionRequest;
use App\Http\Requests\CrearPublicacionRequest;
use App\Http\Resources\PublicacionDetalleResource;
use App\Http\Resources\PublicacionResource;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PublicacionController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new middleware('role:administrador|periodista', only: ['store','update','destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/publicaciones",
     *  summary="Obtener todas los publicaciones de la web",
     *  description="Obtener todos los publicacionesde la web en la llamada a la API",
     *  operationId="indexPublicaciones",
     *  tags={"publicaciones"},
     *  @OA\Response(
     *      response=200,
     *      description="Publicaciones encontradas",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Publicaciones encontradas"),
     *          @OA\Property(property="publicaciones", type="array", @OA\Items(ref="#/components/schemas/Publicacion")),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay equipos"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Equipo no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="El recurso solicitado no fue encontrado")
     *      )
     *  )
     *)
     */
    public function index()
    {
        $publicaciones = Publicacion::orderBy('fechaCreacion', 'desc')->get();

        if ($publicaciones->isEmpty()) {
            return response()->json(status: 204);
        }

        return response()->json(['success' => true, 'message' => 'Publicaciones disponibles', 'publicaciones' => PublicacionResource::collection($publicaciones)], 200);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/publicaciones/{slug}",
     *  summary="Obtener una publicacion de la web",
     *  description="Obtener una publicacion de la web",
     *  operationId="showPublicaciones",
     *  tags={"publicaciones"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug de la publicacion",
     *      required=true,
     *      @OA\Schema(type="string",example="desguace-fc")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Publicaciones encontradas",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Publicaciones encontradas"),
     *          @OA\Property(property="publicaciones", type="array", @OA\Items(ref="#/components/schemas/Publicacion")),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay publicaciones para el recurso"
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
    public function show(Publicacion $publicacion)
    {
        return response()->json(['success' => true, 'message' => 'Publicacion encontrada', 'publicacion' => new PublicacionDetalleResource($publicacion)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/publicaciones",
     *  summary="Crear una publicacion",
     *  description="Crear una publicacion para un recurso concreto",
     *  operationId="storePublicacion",
     *  security={{"bearerAuth": {}}},
     *  tags={"publicaciones"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos de la publicacion",
     *      @OA\JsonContent(
     *          required={"titulo","slug","tipo","texto"},
     *          @OA\Property(property="titulo", type="string", example="Campeones de la liga"),
     *          @OA\Property(property="slug", type="string"),
     *          @OA\Property(property="tipo", type="string", example="[equipos | jugadores | ongs | pabellones | partidos | patrocinadores | retos]"),
     *          @OA\Property(property="texto", type="string", example="El equipo Desguace FC ha sido el campeon de la liga"),
     *          @OA\Property(property="portada", type="boolean"),
     *          @OA\Property(property="rutaaudio", type="string"),
     *          @OA\Property(property="rutavideo", type="string"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Publicacion creada correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Publicacion creado correctamente"),
     *          @OA\Property(property="equipo", type="object", ref="#/components/schemas/Publicacion"),
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
    public function store(CrearPublicacionRequest $request)
    {
        $recurso = $this->getModelInstance($request->tipo, $request->slug);
        $publicacion = Publicacion::create([
            'titulo' => $request->titulo,
            'texto' => $request->texto,
            'publicacionable_type' => $request->tipo,
            'publicacionable_id' => $recurso->id,
            'portada' => $request->portada,
            'rutaaudio' => $request->rutaaudio,
            'rutavideo' => $request->rutavideo,
        ]);

        $nuevo_token = $this->servicio_autenticacion->generateUserToken($this->user);
        return response()->json(['success' => true, 'message' => 'Publicacion creada correctamente', 'publicacion' => new PublicacionDetalleResource($publicacion), 'token' => $nuevo_token], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *  path="/api/publicaciones/{slug}",
     *  summary="Actualizar una publicacion",
     *  description="Actualizar un equipo por su Slug",
     *  operationId="updatePublicacion",
     *  security={{"bearerAuth": {}}},
     *  tags={"publicaciones"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug de la publicacion",
     *      required=true,
     *      @OA\Schema(type="string",example="desguace-fc")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Equipo actualizado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Publicacion actualizada correctamente"),
     *          @OA\Property(property="publicacion", type="object", ref="#/components/schemas/Publicacion"),
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
     *          @OA\Property(property="message", type="string", example="No tienes permisos para borrar ninguna publicacion | No puedes borrar la publicacion {publicacion}"),
     *          @OA\Property(property="code", type="string", example="PUBLICACION_DELETE_FORBIDDEN")
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
    public function update(ActualizarPublicacionRequest $request, Publicacion $publicacion)
    {
        $response = Gate::inspect('update', [$publicacion, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $publicacion->update($request->all());

        return response()->json(['success' => true, 'message' => 'Publicacion actualizada correctamente', 'publicacion' => new PublicacionDetalleResource($publicacion)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/publicaciones/{slug}",
     *  summary="Eliminar una publicacion",
     *  description="Eliminar un equipo por su Slug",
     *  operationId="deletePublicacion",
     *  security={{"bearerAuth": {}}},
     *  tags={"publicaciones"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug de la publicacion",
     *   required=true,
     *   @OA\Schema(type="string")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Equipo eliminado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Publicacion eliminado correctamente"),
     *          @OA\Property(property="token", type="string")
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
     *          @OA\Property(property="message", type="string", example="No tienes permisos para borrar ninguna publicacion | No puedes borrar la publicacion {publicacion}"),
     *          @OA\Property(property="code", type="string", example="PUBLICACION_DELETE_FORBIDDEN")
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
    public function destroy(Publicacion $publicacion)
    {
        $response = Gate::inspect('delete', [$publicacion, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $publicacion->delete();
        $nuevo_token = $this->servicio_autenticacion->generateUserToken($this->user);
        return response()->json(['success' => true, 'message' => 'Publicacion eliminada correctamente', 'token' => $nuevo_token], 200);
    }
}
