<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImagenRequest;
use App\Http\Resources\ImagenResource;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
            return null;
        }

        return $slug ? $className::where('slug', $slug)->first() : new $className;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImagenRequest $request, string $modelo, string $slug)
    {
        $item = $this->getModelInstance($modelo, $slug);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Recurso no encontrado'], 404);
        }

        $imagen = $request->file('imagen');

        $media = $this->servicio_imagenes->uploadImage($item, $imagen);

        $response = Gate::inspect('create', [$media, $this->user]);

        if (!$response->allowed()) {
            $media->delete();
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        return response()->json(['success' => true, 'message' => 'Imagen guardada exitosamente', 'imagen' => new ImagenResource($media)], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ImagenRequest $request, string $modelo, string $slug, string $custom_name)
    {
        $item = $this->getModelInstance($modelo, $slug);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado'], 404);
        }

        $media = $this->servicio_imagenes->getSpecificImage($item, $custom_name);

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'La imagen no existe'], 404);
        }

        $response = Gate::inspect('update', [$media, $this->user]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $media->delete();

        $newMedia = $this->servicio_imagenes->uploadImage($item, $request->file('imagen'), $custom_name);

        return response()->json(['success' => true, 'message' => 'Imagen actualizada', 'imagen' => new ImagenResource($newMedia)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $modelo, string $slug, string $name)
    {
        $item = $this->getModelInstance($modelo, $slug);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado'], 404);
        }

        $media = $this->servicio_imagenes->getSpecificImage($item, $name);

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Imagen no encontrada'], 404);
        }

        $media->delete();

        return response()->json(['success' => true, 'message' => 'Imagen eliminada'], 200);
    }
}
