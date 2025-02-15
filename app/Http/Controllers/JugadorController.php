<?php

namespace App\Http\Controllers;

use App\Http\Resources\JugadorResource;
use App\Models\Jugador;
use Illuminate\Http\Request;


class JugadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/jugadores",
     *  summary="Obtener todos los jugadores de la web",
     *  description="Obtener todos los jugadores en la llamada a la API",
     *  operationId="indexJugadores",
     *  tags={"jugadores"},
     *  @OA\Response(
     *      response=200,
     *      description="Equipos encontrados",
     *      @OA\JsonContent(ref="#/components/schemas/Jugador"),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay equipos"
     *  ),
     *)
     */
    public function index()
    {
        $jugadores = Jugador::with('estudio')->get();
        return JugadorResource::collection($jugadores);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/jugador/{id}",
     *  summary="Obtener un equipo",
     *  description="Obtener un equipo por su id",
     *  operationId="showJugador",
     *  tags={"jugador"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del equipo",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Equipo encontrado",
     *      @OA\JsonContent(ref="#/components/schemas/Equipo")
     * ),
     *  @OA\Response(
     *      response=404,
     *      description="Equipo no encontrado"
     *  )
     *)
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
