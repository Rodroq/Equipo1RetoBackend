<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearPatrocinadorRequest;
use App\Http\Resources\{PatrocinadorDetalleResource, PatrocinadorResource};
use App\Models\Equipo;
use App\Models\Patrocinador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PatrocinadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patrocinadores = Patrocinador::all();

        if ($patrocinadores->isEmpty()) {
            return response()->json(status: 204);
        }

        return response()->json(['success' => true, 'message' => 'Patrocinadores disponibles', 'patrocinadores' => PatrocinadorResource::collection($patrocinadores)], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patrocinador $patrocinador)
    {
        return response()->json(['success' => true, 'message' => 'Patrocinador encontrado', 'patrocinador' => new PatrocinadorDetalleResource($patrocinador)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearPatrocinadorRequest $request)
    {
        $response = Gate::inspect('create', [Patrocinador::class, $request->equipo]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $patrocinador = Patrocinador::create($request->except('equipo'));

        $equipo = Equipo::whereIn('slug', $request->equipo)->pluck('id');
        $patrocinador->equipos()->syncWithoutDetaching($equipo);

        return response()->json(['success' => true, 'message' => 'Patrocinador creado correctamente', 'patrocinador' => new PatrocinadorDetalleResource($patrocinador)], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patrocinador $patrocinador)
    {
        $response = Gate::inspect('delete', [$patrocinador]);

        if (!$response->allowed()) {
            return response()->json(['success' => false, 'message' => $response->message(), 'code' => $response->code()], $response->status());
        }

        $patrocinador->delete();

        $nuevo_token = $this->servicio_autenticacion->generateUserToken($this->user);

        return response()->json(['success' => true, 'message' => 'Patrocionador eliminado correctamente', 'token' => $nuevo_token], 200);
    }
}
