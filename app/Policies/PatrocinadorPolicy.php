<?php

namespace App\Policies;

use App\Models\Patrocinador;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatrocinadorPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, int $equipo_id): Response
    {

        if (!$user->hasPermissionTo('borrar_patrocinador')) return Response::denyWithStatus(403, 'No tienes permisos para crear ningún patrocinador', 'PATROCINADOR_CREATE_FORBIDDEN');
        if ($user->tokenCant("borrar_patrocinador_equipo_{$equipo_id}")) return  Response::denyWithStatus(403, "No puedes crear ningún patrocinador en este equipo", 'PATROCINADOR_CREATE_FORBIDDEN');

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Patrocinador $patrocinador): Response
    {
        $patrocinador_equipo = $patrocinador->equipos()->first();
        if (!$user->hasPermissionTo('borrar_patrocinador')) return Response::denyWithStatus(403, 'No tienes permisos para borrar ningún patrocinador', 'PATROCINADOR_DELETE_FORBIDDEN');
        if ($user->tokenCant("borrar_patrocinador_equipo_{$patrocinador_equipo->id}")) return  Response::denyWithStatus(403, "No puedes borrar patrocinadores del equipo {$patrocinador_equipo->nombre}", 'PATROCINADOR_DELETE_FORBIDDEN');

        return Response::allow();
    }
}
