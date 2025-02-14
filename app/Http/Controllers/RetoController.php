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
     * path="/api/retos",
     * summary="Obtener todos los retos de la web",
     * description="Obtener todos los retos en la llamada a la API",
     * operationId="indexRetos",
     * tags={"retos"},
     * @OA\Response(
     * response=200,
     * description="Retos encontrados",
     * @OA\JsonContent(ref="#/components/schemas/Reto")
     * ),
     * @OA\Response(
     * response=204,
     * description="No hay retos"
     * )
     * )
     */
    public function index()
    {
        $retos = Reto::with('estudio')->get();    

        return RetoResource::collection($retos);
    }


    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     * path="/api/retos/{id}",
     * summary="Obtener un reto",
     * description="Obtener un reto por su id",
     * operationId="showReto",
     * tags={"retos"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="Id del reto",
     * required=true,
     * @OA\Schema(type="integer",example="1")
     * ),
     * @OA\Response(
     * response=200,
     * description="Reto encontrado",
     * @OA\JsonContent(ref="#/components/schemas/Reto")
     * ),
     * @OA\Response(
     * response=404,
     * description="Reto no encontrado"
     * )
     * )
     */
    public function show(Reto $reto)
    {
        return new RetoResource($reto->load('estudio'));
    }
}
