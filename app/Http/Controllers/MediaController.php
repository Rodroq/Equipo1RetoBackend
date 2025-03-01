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
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware('role:administrador|entrenador|periodista', only: ['update', 'destroy']),
            new Middleware('role:entrenador|periodista', only: ['store']),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/imagenes/{imageable_type}",
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
     *      @OA\Schema(type="imageable_type",example="equipos")
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
     *)
     */
    public function store(ImagenRequest $request, string $imageable_type, string $slug)
    {
        $item = $this->getModelInstance($imageable_type, $slug);

        $response = Gate::inspect('create', [Media::class, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $media = $this->servicio_imagenes->uploadImage($item, $request->file('imagen'));


        return response()->json(['success' => true, 'message' => 'Imagen creada correctamente', 'imagen' => new MediaResource($media)], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/imagenes/{imageable_type}/{slug}",
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
     *      @OA\Schema(type="imageable_type",example="equipos")
     *  ),
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="slug de referencia para el recurso concreto de la imagen",
     *      required=true,
     *      @OA\Schema(type="slug",example="desguace-fc")
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

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Imagen no encontrada'], 404);
        }

        $response = Gate::inspect('update', [$media, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $media->delete();

        $newMedia = $this->servicio_imagenes->uploadImage($item, $request->file('imagen'), $file_name);

        return response()->json(['success' => true, 'message' => 'Imagen actualizada correctamente', 'imagen' => new MediaResource($newMedia)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/imagenes/{imageable_type}/{slug}",
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
     *      @OA\Schema(type="imageable_type",example="equipos")
     *  ),
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="slug de referencia para el recurso concreto de la imagen",
     *      required=true,
     *      @OA\Schema(type="slug",example="desguace-fc")
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

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Imagen no encontrada'], 404);
        }

        $media->delete();

        return response()->json(['success' => true, 'message' => 'Imagen eliminada'], 200);
    }
}
