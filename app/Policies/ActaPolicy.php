<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActaPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): Response
    {
        if (!$user->hasPermissionTo('crear_acta')) return Response::denyWithStatus(403, 'No tienes permisos para crear ninguna acta.', 'ACTA_EDIT_FORBIDDEN');
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        if (!$user->hasPermissionTo('editar_acta')) return Response::denyWithStatus(403, 'No tienes permisos para editar ninguna acta.', 'ACTA_EDIT_FORBIDDEN');
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        if (!$user->hasPermissionTo('borrar_acta')) return Response::denyWithStatus(403, 'No tienes permisos para borrar ninguna acta.', 'ACTA_DELETE_FORBIDDEN');

        return Response::allow();
    }
}
