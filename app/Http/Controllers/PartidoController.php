<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearPartidoRequest;
use App\Http\Resources\PartidoResource;
use App\Models\Partido;
use Illuminate\Http\Request;

class PartidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/partidos",
     *  summary="Obtener todos los partidos",
     *  description="Devuelve una lista de todos los partidos registrados",
     *  operationId="indexPartidos",
     *  tags={"partidos"},
     *  @OA\Response(
     *      response=200,
     *      description="Lista de partidos",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Partidos disponibles"),
     *          @OA\Property(property="partidos", type="array", @OA\Items(ref="#/components/schemas/Equipo")),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay partidos"
     *  )
     * )
     */
    public function index()
    {
        $partidos = Partido::with('equipoLoc', 'equipoVis')->get();

        if ($partidos->isEmpty()) {
            return response()->json(status: 204);
        }

        return response()->json(['success' => true, 'message' => 'Partidos disponibles', 'partidos' => ['partidos' => PartidoResource::collection($partidos)]], 200);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/partidos/{slug}",
     *  summary="Obtener un partido específico",
     *  description="Devuelve los detalles de un partido por Slug",
     *  operationId="showPartido",
     *  tags={"partidos"},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del partido",
     *      required=true,
     *      @OA\Schema(type="string", example="partido")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Detalles del partido",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Partido encontrado"),
     *          @OA\Property(property="partido", type="array", @OA\Items(ref="#/components/schemas/Partido")),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Partido no encontrado"
     *  ),
     * )
     */
    public function show(Partido $partido)
    {
        return response()->json(['status' => true, 'message' => 'Partido encontrado', 'partido' => new PartidoResource($partido)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/partidos",
     *  summary="Crear un nuevo partido",
     *  description="Registra un nuevo partido en la base de datos",
     *  operationId="storePartido",
     *  tags={"partidos"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del partido",
     *      @OA\JsonContent(
     *          required={"fecha", "hora", "equipoL", "equipoV"},
     *          @OA\Property(property="fecha", type="string", format="date", example="2025-02-20"),
     *          @OA\Property(property="hora", type="string", format="time", example="16:00:00"),
     *          @OA\Property(property="equipoL", type="integer", example=1),
     *          @OA\Property(property="equipoV", type="integer", example=2)
     *      )
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Partido creado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Equipos disponibles"),
     *          @OA\Property(property="partido", type="array", @OA\Items(ref="#/components/schemas/Partido")),
     *      ),
     *  ),
     * )
     */
    public function store(CrearPartidoRequest $request)
    {
        $request->validated();

        $partido = Partido::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'equipoL' => $request->equipoL,
            'equipoV' => $request->equipoV,
            'golesL' => $request->golesL,
            'golesV' => $request->golesV,
            'pabellon_id' => $request->pabellon_id,
            'usuarioIdCreacion' => $request->usuarioIdCreacion,
        ]);

        return response()->json(['success' => true, 'message' => 'Partido creado correctamente', 'data' => ['partido' => new PartidoResource($partido)]], 200);
    }
}
