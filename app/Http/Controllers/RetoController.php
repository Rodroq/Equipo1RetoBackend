<?php

namespace App\Http\Controllers;

use App\Http\Resources\RetoResource;
use Illuminate\Http\Request;
use App\Models\Reto;

class RetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/retos",
     *  summary="Obtener todos los retos de la web",
     *  description="Obtener todos los retos en la llamada a la API",
     *  operationId="indexRetos",
     *  tags={"retos"},
     *  @OA\Response(
     *      response=200,
     *      description="Retos encontrados",
     *      @OA\JsonContent(ref="#/components/schemas/Reto")
     *  )
     * )
     */
    public function index()
    {
        $retos = Reto::with('estudio')->get();

        return response()->json(['success' => true, 'message' => 'Retos encontrados', 'reto' =>  RetoResource::collection($retos)], 200);
    }


    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/retos/{slug}",
     *  summary="Obtener un reto",
     *  description="Obtener un reto por su Slug",
     *  operationId="showReto",
     *  tags={"retos"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del reto",
     *      required=true,
     *      @OA\Schema(type="string",example="foodtruck")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Reto encontrado",
     *      @OA\JsonContent(ref="#/components/schemas/Reto")
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Reto no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No hay equipos")
     *      )
     *  )
     * )
     */
    public function show(Reto $reto)
    {
        return response()->json(['success' => true, 'message' => 'Reto encontrado', 'reto' => new RetoResource($reto->load('estudio'))], 200);
    }
}
