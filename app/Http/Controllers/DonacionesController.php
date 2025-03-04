<?php

namespace App\Http\Controllers;

use App\Http\Resources\DonacionesResource;
use App\Models\Donaciones;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="donaciones",
 *     description="donaciones"
 * )
 */
class DonacionesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/donaciones",
     *     summary="Obtener todas las donaciones",
     *     tags={"donaciones"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de donaciones obtenida con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Donaciones encontradas con éxito"),
     *             @OA\Property(property="donaciones", type="array", @OA\Items(ref="#/components/schemas/Donaciones"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $donaciones = Donaciones::all();
        return response()->json([
            'success' => true,
            'message' => 'Donaciones encontradas con éxito',
            'donaciones' => DonacionesResource::collection($donaciones)
        ], 200);
    }
}
