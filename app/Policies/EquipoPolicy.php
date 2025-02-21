<?php

namespace App\Policies;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipoPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('crear_equipo')
            ? Response::allow()
            : Response::denyWithStatus(403, 'No puedes crear ningún equipo', 'EQUIPO_NOT_CREATED');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Equipo $equipo): Response
    {
        if (!$user->hasPermissionTo('borrar_equipo')) return Response::denyWithStatus(403, 'No tienes permisos para editar ningún equipo', 'EQUIPO_EDIT_FORBIDDEN');
        if (!$user->tokenCan("editar_equipo_{$equipo->id}")) return  Response::denyWithStatus(403, "No puedes editar el equipo {$equipo->nombre}.", 'EQUIPO_EDIT_FORBIDDEN');

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Equipo $equipo): Response
    {
        if (!$user->hasPermissionTo('borrar_equipo')) return Response::denyWithStatus(403, 'No tienes permisos para borrar ningún equipo', 'EQUIPO_DELETE_FORBIDDEN');
        if (!$user->tokenCan("borrar_equipo_{$equipo->id}")) return  Response::denyWithStatus(403, "No puedes borrar el equipo {$equipo->nombre}", 'EQUIPO_DELETE_FORBIDDEN');

        return Response::allow();
    }
}
