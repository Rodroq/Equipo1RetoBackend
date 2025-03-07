<?php

namespace App\Policies;

use App\Models\Publicacion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PublicacionPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Publicacion $publicacion): Response
    {
        if (!$user->hasPermissionTo('editar_publicacion')) return Response::denyWithStatus(403, "No tienes permisos para editar ninguna publicacion", 'PUBLICACION_EDIT_FORBIDDEN');
        if ($user->tokenCant("editar_publicacion_{$publicacion->id}")) return  Response::denyWithStatus(403, "No puedes editar la publicacion {$publicacion->titulo}", 'PUBLICACION_EDIT_FORBIDDEN');

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Publicacion $publicacion): Response
    {

        if (!$user->hasPermissionTo('borrar_publicacion')) return Response::denyWithStatus(403, "No tienes permisos para borrar ninguna publicacion", 'PUBLICACION_DELETE_FORBIDDEN');
        if ($user->tokenCant("borrar_publicacion_{$publicacion->id}")) return  Response::denyWithStatus(403, "No puedes borrar la publicacion {$publicacion->titulo}", 'PUBLICACION_DELETE_FORBIDDEN');

        return Response::allow();
    }
}
