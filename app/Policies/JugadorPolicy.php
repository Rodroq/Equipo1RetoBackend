<?php

namespace App\Policies;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JugadorPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('crear_jugador')
            ? Response::allow()
            : Response::denyWithStatus(403, 'No puedes crear ningún jugador', 'JUGADOR_CREATE_FORBIDDEN');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Jugador $jugador): Response
    {
        $equipo = $jugador->equipo;
        if (!$user->hasPermissionTo('editar_equipo')) return Response::denyWithStatus(403, 'No tienes permisos para editar ningún jugador', 'JUGADOR_EDIT_FORBIDDEN');
        if (!$user->tokenCan("editar_jugador_equipo_{$equipo->id}")) return  Response::denyWithStatus(403, "No puedes editar el jugador {$jugador->nombre} del equipo {$equipo->nombre}", 'JUGADOR_EDIT_FORBIDDEN');

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Jugador $jugador): Response
    {
        $equipo = $jugador->equipo;
        if (!$user->hasPermissionTo('borrar_jugador')) return Response::denyWithStatus(403, 'No tienes permisos para borrar ningún jugador', 'JUGADOR_DELETE_FORBIDDEN');
        if (!$user->tokenCan("borrar_jugador_equipo_{$equipo->id}")) return  Response::denyWithStatus(403, "No puedes borrar el jugador {$jugador->nombre} del equipo {$equipo->nombre}", 'JUGADOR_DELETE_FORBIDDEN');

        return Response::allow();
    }
}
