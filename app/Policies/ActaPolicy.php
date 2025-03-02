<?php

namespace App\Policies;

use App\Models\Acta;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActaPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): Response
    {
        if (!$user->hasPermissionTo('crear_acta')) return Response::denyWithStatus(403, 'No tienes permisos para crear ninguna acta', 'ACTA_EDIT_FORBIDDEN');
        return Response::allow();
    }
}
