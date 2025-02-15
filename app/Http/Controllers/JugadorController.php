<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarJugadorRequest;
use App\Http\Requests\CrearJugadorRequest;
use App\Http\Resources\JugadorResource;
use App\Models\Equipo;
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
     *      description="jugadors encontrados",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugadores disponibles"),
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Jugador")),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="Jugador no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No hay jugadores")
     *       ),
     *  ),
     * )
     */
    public function index()
    {
        $jugadores = Jugador::with('estudio')->get();

        if ($jugadores->isEmpty()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No hay jugadores'
                ],
                204
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Equipos disponibles',
                'data' => ['equipos' => JugadorResource::collection($jugadores)],
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/jugadores/{id}",
     *  summary="Obtener un jugador",
     *  description="Obtener un jugador por su id",
     *  operationId="showJugador",
     *  tags={"jugadores"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del jugador",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="jugador encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipo encontrado"),
     *          @OA\Property(property="data", type="object", ref="#/components/schemas/Equipo"),
     *      ),
     * ),
     *  @OA\Response(
     *      response=404,
     *      description="Jugador no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Jugador no encontrado")
     *       ),
     *  ),
     * )
     */
    public function show($jugador)
    {
        $jugador = Jugador::find($jugador);

        if (!$jugador) {
            return response()->json([
                'success' => false,
                'message' => 'Jugador no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Equipo encontrado',
            'data' => new JugadorResource($jugador)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/jugadores",
     *  summary="Crear un nuevo jugador",
     *  description="Crear un nuevo jugador",
     *  operationId="storeJugador",
     *  tags={"jugadores"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del jugador",
     *      @OA\JsonContent(
     *          required={"nombre"},
     *          @OA\Property(property="nombre", type="string", example="Jugador 1"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="jugador creado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugador creado correctamente"),
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Jugador")),
     *     ),
     *  ),
     * )
     */
    public function store(CrearJugadorRequest $request)
    {
        $request->validated();

        $equipo = Equipo::where('nombre', $request->equipo)->first();

        if (!$equipo) {
            return response()->json([
                'success' => false,
                'message' => 'Jugador no encontrado'
            ], 404);
        }
        $jugador = Jugador::create([
            'nombre' => $request->nombre,
            'apellido1' => $request->grupo,
            'apellido2' => $request->grupo,
            'tipo' => $request->grupo,
            'dni' => $request->grupo,
            'email' => $request->grupo,
            'telefono' => $request->grupo,
            'equipo_id' => $equipo->id,
            /* Este campo se tendra que eliminar y realizar el agregado a través del modelo con la autenticacion de usuarios */
            'usuarioIdCreacion' => $request->usuarioIdCreacion
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jugador creado correctamente',
            'data' => ['jugador' => $jugador]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *  path="/api/jugadores/{id}",
     *  summary="Actualizar un jugador",
     *  description="Actualizar un jugador",
     *  operationId="updateJugador",
     *  tags={"jugadores"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del jugador",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del jugador",
     *      @OA\JsonContent(
     *          @OA\Property(property="nombre", type="string", example="Jugador 1"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=201,
     *     description="Jugador actualizado correctamente",
     *     @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugador actualizado correctamente"),
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Jugador")),
     *     ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Jugador no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Jugador no encontrado")
     *       ),
     *  ),
     * )
     */
    public function update(ActualizarJugadorRequest $request, $jugador)
    {
        $jugador = jugador::find($jugador);

        // Verificar si el jugador existe
        if (!$jugador) {
            return response()->json([
                'success' => false,
                'message' => 'Jugador no encontrado'
            ], 404);
        }

        // Si la validación pasa, se procede a actualizar
        $jugador->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'jugador actualizado correctamente',
            'data' => ['jugador' => $jugador]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/jugadores/{id}",
     *  summary="Eliminar un jugador",
     *  description="Eliminar un jugador por su id",
     *  operationId="deleteJugador",
     *  tags={"jugadores"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del jugador",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Jugador eliminado correctamente",
     *       @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Jugador eliminado correctamente")
     *       )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Jugador no encontrado",
     *       @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Jugador no encontrado")
     *       )
     *  ),
     * ),
     */
    public function destroy($jugador)
    {
        $jugador = Jugador::find($jugador);

        if (!$jugador) {
            return response()->json(['success' => false, 'message' => 'Jugador no encontrado'], 404);
        }

        $jugador->delete();

        return response()->json(['success' => true, 'message' => 'Jugador eliminado correctamente'], 200);
    }
}
