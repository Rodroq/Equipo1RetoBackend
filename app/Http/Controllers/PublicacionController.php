<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarPublicacionRequest;
use App\Http\Requests\CrearPublicacionRequest;
use App\Http\Resources\PublicacionDetalleResource;
use App\Http\Resources\PublicacionResource;
use App\Models\Publicacion;
use Illuminate\Database\Eloquent\Relations\Relation;
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
            new Middleware('role:administrador|periodista', only: ['update', 'destroy']),
            new Middleware('role:periodista', only: ['store']),
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
     *  path="/api/publicaciones/{publicacion_type}/{slug}/{title}",
     *  summary="Obtener todas los publicaciones de la web",
     *  description="Obtener todos los publicacionesde la web en la llamada a la API",
     *  operationId="showPublicaciones",
     *  tags={"publicaciones"},
     *  @OA\Parameter(
     *      name="publicacion_type",
     *      in="path",
     *      description="publicacion_type de referencia para la imagen",
     *      required=true,
     *      @OA\Schema(type="publicacion_type",example="equipos")
     *  ),
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="slug de referencia para el recurso concreto de la imagen",
     *      required=true,
     *      @OA\Schema(type="slug",example="publicacion")
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
        return response()->json(['success' => true, 'message' => 'Publicacion encontrada', 'equipo' => new PublicacionDetalleResource($publicacion)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/publicaiones/{morphed_model}/{slug}",
     *  summary="Crear una publicacion",
     *  description="Crear una publicacion para un recurso concreto",
     *  operationId="storePublicacion",
     *  security={{"bearerAuth": {}}},
     *  tags={"publicaciones"},
     *  @OA\Parameter(
     *      name="morphed_model",
     *      in="path",
     *      description="tipo de modelo para la referencia de la publicacion",
     *      required=true,
     *      @OA\Schema(type="morphed_model",example="equipos")
     *  ),
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="slug de referencia para el recurso concreto de la publicacion",
     *      required=true,
     *      @OA\Schema(type="slug",example="desguace-fc")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos de la publicacion",
     *      @OA\JsonContent(
     *          required={"titulo","texto"},
     *          @OA\Property(property="titulo", type="string", example="Campeones de la liga"),
     *          @OA\Property(property="texto", type="string", example="El equipo Desguace FC ha sido el campeon de la liga"),
     *          @OA\Property(property="portada", type="boolean"),
     *          @OA\Property(property="rutaaudio", type="integer"),
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
    public function store(CrearPublicacionRequest $request, string $morphed_model, string $slug)
    {
        $recurso = $this->getModelInstance($morphed_model, $slug);
        $publicacion = Publicacion::create([
            'titulo' => $request->titulo,
            'texto' => $request->texto,
            'publicacionable_type' => $request->tipo,
            'publicacionable_id' => $recurso->id,
            'portada' => $request->portada,
            'rutaaudio' => $request->rutaaudio,
            'rutavideo' => $request->rutavideo,
        ]);

        $this->servicio_autenticacion->generateUserToken($this->user);
        return response()->json(['success' => true, 'message' => 'Publicacion creada correctamente', 'publicacion' => new PublicacionResource($publicacion)], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActualizarPublicacionRequest $request, Publicacion $publicacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publicacion $publicacion)
    {
        //
    }
}
