<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImagenRequest;
use App\Http\Resources\ImagenResource;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class ImagenController extends Controller  /* implements HasMiddleware */
{
    /* public static function middleware(): array
    {
        return [
            //seguridad para la autenticación del ususario
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware('role:administrador|entrenador|periodista', only: ['store', 'update', 'destroy']),
        ];
    } */

    private function getModelInstance(string $model, ?string $slug = null)
    {
        $className = Relation::getMorphedModel($model);

        if (!class_exists($className)) {
            return null;
        }

        return $slug ? $className::where('slug', $slug)->first() : new $className;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($modelo)
    {
        $modelo = $this->getModelInstance($modelo);

        if (!$modelo) {
            return response()->json(['success' => false, 'message' => 'Recurso no disponibles'], 400);
        }

        $items = $modelo::all();

        $images = $items->map(fn($item) => [
            'slug' => $item->slug,
            'imagen' => optional($this->servicio_imagenes->getFirstImage($item))->getUrl() ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Imagenes encontradas', 'imagenes' => $images], 200);
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

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Error al subir la imagen'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Imagen guardada exitosamente', 'imagen' => new ImagenResource($media)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $modelo, string $slug)
    {
        $item = $this->getModelInstance($modelo, $slug);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado'], 404);
        }

        $media = $this->servicio_imagenes->getImages($item);

        if ($media->isEmpty()) {
            return response()->json(['success' => true, 'message' => 'No hay imágenes'], 204);
        }

        return response()->json(['success' => true, 'message' => 'Imágenes encontradas', 'imagenes' => ImagenResource::collection($media)], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ImagenRequest $request, string $modelo, string $slug, string $name)
    {
        $item = $this->getModelInstance($modelo, $slug);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado'], 404);
        }

        $media = $this->servicio_imagenes->getSpecificImage($item, $name);

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'La imagen no existe'], 404);
        }

        if ($media) {
            $this->servicio_imagenes->delete($media);
        }

        $newMedia = $this->servicio_imagenes->uploadImage($item, $request->file('imagen'));

        if (!$newMedia) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar la imagen'], 500);
        }

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

        $this->servicio_imagenes->delete($media);

        return response()->json(['success' => true, 'message' => 'Imagen eliminada'], 200);
    }
}
