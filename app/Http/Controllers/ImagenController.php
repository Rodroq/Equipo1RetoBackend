<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearImagenRequest;
use App\Http\Resources\ImagenResource;
use App\Models\Imagen;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

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

    public function __construct()
    {
        $this->servicio_imagenes = new ImageService('images_tournament');
    }

    /**
     * Display a listing of the resource.
     */
    public function index($modelo)
    {
        $clase_modelo = Relation::getMorphedModel($modelo);

        if (!class_exists($clase_modelo) || !$clase_modelo) {
            return response()->json(['success' => false, 'message' => 'Imagenes no disponibles'], 400);
        }

        $items = $clase_modelo::all();

        $images = $items->map(function ($item) use ($modelo) {
            $image = $this->servicio_imagenes->getFirstImage($item, "{$modelo}-{$item->slug}-images");
            return [

                'slug' => $item->slug,
                'imagen' => $image ? new ImagenResource($image) : null,
            ];
        });

        return response()->json(['success' => true, 'message' => 'Imagenes encontradas', 'imagenes' => $images], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearImagenRequest $request, string $modelo, string $slug)
    {
        $clase_modelo = Relation::getMorphedModel($modelo);

        if (!$clase_modelo || !$clase_modelo) {
            return response()->json(['success' => false, 'message' => 'Imagenes no disponibles'], 404);
        }

        $item = $clase_modelo::where('slug', $slug)->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado'], 404);
        }

        $imagen = $request->file('image');

        $media = $this->servicio_imagenes->uploadImage($item, $imagen);

        return response()->json(['success' => true, 'message' => 'Imagen guardada exitosamente', 'imagen' => new ImagenResource($media)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Imagen $imagen) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imagen $imagen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imagen $imagen)
    {
        //
    }
}
