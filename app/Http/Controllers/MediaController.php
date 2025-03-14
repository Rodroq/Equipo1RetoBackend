<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImagenRequest;
use App\Http\Resources\MediaResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller  implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            //seguridad para la autenticación del ususario
            new Middleware('auth:sanctum'),
            new middleware('role:administrador|entrenador|periodista', only: ['store','update','destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/imagenes/{imageable_type}/{slug}",
     *  summary="Obtener todas las imagenes pertenecientes a un usuario",
     *  description="Obtener todas las imagenes pertenecientes a un usuario a través del servicio de imagenes de la API",
     *  operationId="indexImagen",
     *  security={{"bearerAuth": {}}},
     *  tags={"imagenes"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Archivo de la imagen",
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="imagen",
     *                  type="string",
     *                  description="nueva imagen para el recurso",
     *                  format="binary",
     *              )
     *          ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Imagenes encontradas",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Imagenes encontradas"),
     *          @OA\Property(property="imagen", type="object",
     *              @OA\Property(property="nombre",type="string"),
     *              @OA\Property(property="url",type="string")
     *          ),
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
    public function index()
    {
        $media = $this->servicio_imagenes->getImagesUser($this->user->id);

        if ($media->isEmpty()) {
            return response()->json(status: 204);
        }

        return response()->json(['success' => true, 'message' => 'Imagenes encontradas', 'imagenes' => MediaResource::collection($media)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/imagenes/{imageable_type}/{slug}",
     *  summary="Crear la imagen de un recurso",
     *  description="Crear una imagen de un recurso a través del servicio de imagenes de la API",
     *  operationId="storeImagen",
     *  security={{"bearerAuth": {}}},
     *  tags={"imagenes"},
     *  @OA\Parameter(
     *      name="imageable_type",
     *      in="path",
     *      description="imageable_type de referencia para la imagen",
     *      required=true,
     *      @OA\Schema(type="string",example="equipos")
     *  ),
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="slug de referencia para el recurso concreto de la imagen",
     *      required=true,
     *      @OA\Schema(type="string",example="desguace-fc")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Archivo de la imagen",
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="imagen",
     *                  type="string",
     *                  description="nueva imagen para el recurso",
     *                  format="binary",
     *              )
     *          ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Imagen creada correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Imagen creada correctamente"),
     *          @OA\Property(property="imagen", type="object",
     *              @OA\Property(property="nombre",type="string"),
     *              @OA\Property(property="url",type="string")
     *          ),
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
     *  @OA\Response(
     *      response=404,
     *      description="No encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="El recurso solicitado no fue encontrado.")
     *      )
     *  ),
     *)
     */
    public function store(ImagenRequest $request, string $imageable_type, string $slug)
    {
        $item = $this->getModelInstance($imageable_type, $slug);

        $response = Gate::inspect('create', [Media::class, $item->id]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $media = $this->servicio_imagenes->uploadImage($item, $request->file('imagen'), $this->user->id);


        return response()->json(['success' => true, 'message' => 'Imagen creada correctamente', 'imagen' => new MediaResource($media)], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/imagenes/{imageable_type}/{slug}/{file_name}",
     *  summary="Modificar la imagen de un recurso",
     *  description="Modificar la imagen de un recurso a través del servicio de imagenes de la API",
     *  operationId="updateImagen",
     *  security={{"bearerAuth": {}}},
     *  tags={"imagenes"},
     *  @OA\Parameter(
     *      name="imageable_type",
     *      in="path",
     *      description="imageable_type de referencia para la imagen",
     *      required=true,
     *      @OA\Schema(type="string",example="equipos")
     *  ),
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="slug de referencia para el recurso concreto de la imagen",
     *      required=true,
     *      @OA\Schema(type="string",example="desguace-fc")
     *  ),
     *  @OA\Parameter(
     *      name="file_name",
     *      in="path",
     *      description="nombre de referencia del archivo a modificar para el recurso concreto de la imagen",
     *      required=true,
     *      @OA\Schema(type="string",example="desguace-fc")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos de la imagen",
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="imagen",
     *                  type="string",
     *                  description="nueva imagen para el recurso",
     *                  format="binary",
     *              )
     *          ),
     *      )
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Imagen actualizada correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Imagen actualizada correctamente"),
     *          @OA\Property(property="imagen", type="object",
     *              @OA\Property(property="nombre",type="string"),
     *              @OA\Property(property="url",type="string")
     *          ),
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
     *  @OA\Response(
     *      response=404,
     *      description="No encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="El recurso solicitado no fue encontrado.")
     *      )
     *  ),
     *)
     */
    public function update(ImagenRequest $request, string $imageable_type, string $slug, string $file_name)
    {
        $item = $this->getModelInstance($imageable_type, $slug);

        $media = $this->servicio_imagenes->getSpecificImage($item, $file_name);

        $response = Gate::inspect('update', [$media]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $media->delete();

        $newMedia = $this->servicio_imagenes->uploadImage($item, $request->file('imagen'), $this->user->id, $file_name);

        return response()->json(['success' => true, 'message' => 'Imagen actualizada correctamente', 'imagen' => new MediaResource($newMedia)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/imagenes/{imageable_type}/{slug}/{file_name}",
     *  summary="Eliminar la imagen de un recurso",
     *  description="Elimina la imagen de un recurso a través del servicio de imagenes de la API",
     *  operationId="destroyImagen",
     *  security={{"bearerAuth": {}}},
     *  tags={"imagenes"},
     *  @OA\Parameter(
     *      name="imageable_type",
     *      in="path",
     *      description="imageable_type de referencia para la imagen",
     *      required=true,
     *      @OA\Schema(type="string",example="equipos")
     *  ),
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="slug de referencia para el recurso concreto de la imagen",
     *      required=true,
     *      @OA\Schema(type="string",example="desguace-fc")
     *  ),
     *  @OA\Parameter(
     *      name="file_name",
     *      in="path",
     *      description="nombre de referencia del archivo a modificar para el recurso concreto de la imagen",
     *      required=true,
     *      @OA\Schema(type="string",example="desguace-fc")
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Imagen borrada correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Imagen actualizada correctamente"),
     *          @OA\Property(property="imagen", type="object"),
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
     *  @OA\Response(
     *      response=404,
     *      description="No encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="El recurso solicitado no fue encontrado.")
     *      )
     *  ),
     *)
     */
    public function destroy(string $imageable_type, string $slug, string $name)
    {
        $item = $this->getModelInstance($imageable_type, $slug);

        $media = $this->servicio_imagenes->getSpecificImage($item, $name);

        Gate::inspect('delete', [$media]);

        $media->delete();

        return response()->json(['success' => true, 'message' => 'Imagen eliminada'], 200);
    }
}
