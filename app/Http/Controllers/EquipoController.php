<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipoResource;
use App\Models\Equipo;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="API Equipos", version="1.0",description="API de equipos del torneo solidario",
 * @OA\Server(url="http://localhost:8000"),
 * @OA\Contact(email="email@gmail.com"))
 */
class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/equipos",
     *  summary="Obtener todos los equipos de la web",
     *  description="Obtener todos los equipos en la llamada a la API",
     *  operationId="index",
     *  tags={"equipos"},
     *  @OA\Response(
     *  response=200,
     *  description="Equipos encontrados",
     *  @OA\JsonContent(ref="#/components/schemas/Equipo")
     * ),
     *  @OA\Response(
     *  response=204,
     *  description="No hay equipos"
     *  )
     * )
     */
    public function index()
    {
        $equipos = Equipo::with('jugadores')->get();

        return EquipoResource::collection($equipos);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/equipos/{id}",
     *  summary="Obtener un equipo",
     *  description="Obtener un equipo por su id",
     *  operationId="show",
     *  tags={"equipos"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del equipo",
     *   required=true,
     *   @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\Response(
     *  response=200,
     *  description="Equipo encontrado",
     *  @OA\JsonContent(ref="#/components/schemas/Equipo")
     * ),
     *  @OA\Response(
     *  response=404,
     *  description="Equipo no encontrado"
     *  )
     * )
     */
    public function show(Equipo $equipo){
        return new EquipoResource($equipo->load('jugadores'));
    }
}
