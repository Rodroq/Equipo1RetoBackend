<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarEquipoRequest;
use App\Http\Requests\CrearEquipoRequest;
use App\Http\Resources\EquipoResource;
use App\Models\Equipo;
use Illuminate\Http\Request;


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
     *  operationId="indexEquipos",
     *  tags={"equipos"},
     *  @OA\Response(
     *      response=200,
     *      description="Equipos encontrados",
     *      @OA\JsonContent(ref="#/components/schemas/Equipo")
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay equipos"
     *  )
     *)
     */
    public function index()
    {
        $equipos = Equipo::with('jugadores', 'centro')->get();

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
     *  operationId="showEquipo",
     *  tags={"equipos"},
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
    public function show($equipo)
    {
        $equipo = Equipo::find($equipo);
        if (!$equipo) {
            return response()->json(['message' => 'Equipo no encontrado'], 404);
        }

        return new EquipoResource($equipo->load('jugadores'));
    }

    /**
     * @OA\Post(
     *  path="/api/equipos",
     *  summary="Crear un equipo con sus jugadores",
     *  description="Crear un equipo con sus jugadores",
     *  operationId="storeEquipo",
     *  tags={"equipos"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del equipo",
     *      @OA\JsonContent(
     *          required={"nombre","jugadores"},
     *          @OA\Property(property="nombre", type="string", example="Equipo 1"),
     *          @OA\Property(property="centro_id", type="integer", example="1"),
     *          @OA\Property(
     *              property="jugadores",
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Jugador"),
     *          ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Equipo creado",
     *      @OA\JsonContent(ref="#/components/schemas/Equipo")
     *  ),
     *)
     */
    public function store(CrearEquipoRequest $request)
    {
        $request->validated();

        $equipo = Equipo::create([
            'nombre' => $request->nombre,
            'grupo' => $request->grupo,
            'centro_id' => $request->centro_id,
            /* Este campo se tendra que eliminar y realizar el agregado a través del modelo con la autenticacion de usuarios */
            'usuarioIdCreacion' => $request->usuarioIdCreacion
        ]);

        $equipo->jugadores()->createMany($request->jugadores);

        return response()->json(['message' => 'Equipo creado correctamente', 'equipo' => $equipo], 200);
    }

    /**
     * @OA\Put(
     *  path="/api/equipos/{id}",
     *  summary="Actualizar un equipo",
     *  description="Actualizar un equipo",
     *  operationId="updateEquipo",
     *  tags={"equipos"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del equipo",
     *      required=true,
     *      @OA\Schema(type="integer",example="1")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del equipo",
     *      @OA\JsonContent(
     *          @OA\Property(property="nombre", type="string", example="Equipo 1"),
     *          @OA\Property(property="centro_id", type="integer", example="1"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=201,
     *     description="Equipo actualizado correctamente",
     *     @OA\JsonContent(ref="#/components/schemas/Equipo"),
     *  ),
     *  @OA\Response(
     *     response=404,
     *     description="Equipo no encontrado",
     *     @OA\JsonContent(ref="#/components/schemas/Equipo"),
     *  ),
     *)
     */
    public function update(ActualizarEquipoRequest $request, $equipo)
    {
        $equipo = Equipo::find($equipo);

        // Verificar si el equipo existe
        if (!$equipo) {
            return response()->json(['message' => 'Equipo no encontrado'], 404);
        }

        // Si la validación pasa, se procede a actualizar
        $equipo->update($request->only('nombre', 'grupo', 'centro_id'));

        return response()->json(['message' => 'Equipo actualizado correctamente', 'equipo' => $equipo], 200);
    }


    /**
     * @OA\Delete(
     *  path="/api/equipos/{id}",
     *  summary="Eliminar un equipo",
     *  description="Eliminar un equipo por su id",
     *  operationId="deleteEquipo",
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
     *  description="Equipo eliminado correctamente",
     * ),
     *  @OA\Response(
     *  response=404,
     *  description="Equipo no encontrado"
     *  ),
     * ),
     */
    public function destroy($equipo)
    {
        $equipo = Equipo::find($equipo);

        if (!$equipo) {
            return response()->json(['message' => 'Equipo no encontrado'], 404);
        }

        $equipo->delete();

        return response()->json(['message' => 'Equipo eliminado correctamente'], 200);
    }
}
