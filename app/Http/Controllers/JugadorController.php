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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
