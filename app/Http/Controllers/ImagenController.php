<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImagenRequest;
use App\Http\Resources\ImagenResource;
use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImagenController extends Controller  implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            //seguridad para la autenticación del ususario
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware('role:administrador|entrenador|periodista', only: ['store', 'update', 'destroy']),
        ];
    }

    private function getModelInstance(string $model, ?string $slug = null)
    {
        $className = Relation::getMorphedModel($model);

        if (!class_exists($className)) {
            throw new NotFoundHttpException();
        }

        return $slug ? $className::where('slug', $slug)->first() : new $className;
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/imagenes/{modelo}",
     *  summary="Crear un equipo con sus jugadores",
     *  description="Crear un equipo con sus jugadores",
     *  operationId="storeImagen",
     *  security={{"bearerAuth": {}}},
     *  tags={"imagenes"},
     *  @OA\Parameter(
     *      name="modelo",
     *      in="path",
     *      description="modelo de referencia para la imagen",
     *      required=true,
     *      @OA\Schema(type="modelo",example="equipos")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos de la imagen",
     *      @OA\JsonContent(
     *          required={"imagen"},
     *          @OA\Property(property="imagen", type="file"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Imagen creada correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Imagen creada correctamente"),
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
     *          @OA\Property(property="message", type="string", example="No puedes crear ninguna imagen")
     *      )
     *  ),
     *)
     */
    public function store(ImagenRequest $request, string $modelo, string $slug)
    {
        $item = $this->getModelInstance($modelo, $slug);

        $response = Gate::inspect('create', [Media::class, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $media = $this->servicio_imagenes->uploadImage($item, $request->file('imagen'));


        return response()->json(['success' => true, 'message' => 'Imagen creada correctamente', 'imagen' => new ImagenResource($media)], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/imagenes/{modelo}/{slug}",
     *  summary="Modificar la imagen de un recurso",
     *  description="Modificar la imagen de un recurso a través del servicio de imagenes de la API",
     *  operationId="updateImagen",
     *  security={{"bearerAuth": {}}},
     *  tags={"imagenes"},
     *  @OA\Parameter(
     *      name="modelo",
     *      in="path",
     *      description="modelo de referencia para la imagen",
     *      required=true,
     *      @OA\Schema(type="modelo",example="equipos")
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
     *      @OA\JsonContent(
     *          required={"imagen"},
     *          @OA\Property(property="imagen", type="file"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Imagen actualizada correctamente",
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
     *          @OA\Property(property="message", type="string", example="No puedes crear ninguna imagen")
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
    public function update(ImagenRequest $request, string $modelo, string $slug, string $custom_name)
    {
        $item = $this->getModelInstance($modelo, $slug);

        $media = $this->servicio_imagenes->getSpecificImage($item, $custom_name);

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Imagen no encontrada'], 404);
        }

        $response = Gate::inspect('update', [$media, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $media->delete();

        $newMedia = $this->servicio_imagenes->uploadImage($item, $request->file('imagen'), $custom_name);

        return response()->json(['success' => true, 'message' => 'Imagen actualizada correctamente', 'imagen' => new ImagenResource($newMedia)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/imagenes/{modelo}/{slug}",
     *  summary="Eliminar la imagen de un recurso",
     *  description="Elimina la imagen de un recurso a través del servicio de imagenes de la API",
     *  operationId="destroyImagen",
     *  security={{"bearerAuth": {}}},
     *  tags={"imagenes"},
     *  @OA\Parameter(
     *      name="modelo",
     *      in="path",
     *      description="modelo de referencia para la imagen",
     *      required=true,
     *      @OA\Schema(type="modelo",example="equipos")
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
     *          @OA\Property(property="message", type="string", example="No puedes crear ninguna imagen")
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
    public function destroy(string $modelo, string $slug, string $name)
    {
        $item = $this->getModelInstance($modelo, $slug);

        $media = $this->servicio_imagenes->getSpecificImage($item, $name);

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Imagen no encontrada'], 404);
        }

        $media->delete();

        return response()->json(['success' => true, 'message' => 'Imagen eliminada'], 200);
    }
}
