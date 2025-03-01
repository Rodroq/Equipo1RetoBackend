<?php

namespace App\Policies;

use App\Models\{Equipo, Publicacion, User};
use Illuminate\Auth\Access\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if (!$user->hasPermissionTo('crear_imagen')) return Response::denyWithStatus(403, 'No tienes permisos para crear ninguna imagen', 'IMAGEN_CREATE_FORBIDDEN');

        if ($user->hasRole('entrenador')) {
            $equipo = Equipo::where('usuarioIdCreacion', $user->id)->first();
            return $user->tokenCant("crear_imagen_equipo_{$equipo->id}") || $user->tokenCant("crear_imagen_jugador_equipo_{$equipo->id}")
                ?: Response::denyWithStatus(403, 'No puedes crear ninguna imagen en este recurso', 'IMAGEN_CREATE_FORBIDDEN');
        }

        if ($user->hasRole('periodista')) {
            $publicacion = Publicacion::where('usuarioIdCreacion', $user->id)->first();
            return $user->tokenCant("crear_imagen_publicacion_{$publicacion->id}")
                ?: Response::denyWithStatus(403, 'No puedes crear ninguna imagen en este recurso', 'IMAGEN_CREATE_FORBIDDEN');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Media $media): Response
    {
        if (!$user->hasPermissionTo('editar_imagen')) return Response::denyWithStatus(403, 'No tienes permisos para editar ninguna imagen', 'IMAGEN_DELETE_FORBIDDEN');

        if ($user->hasRole('entrenador')) {
            $equipo = $media->model()->first();
            return $user->tokenCant("editar_imagen_equipo_{$equipo->id}") || $user->tokenCant("editar_imagen_jugador_equipo_{$equipo->id}")
                ?: Response::denyWithStatus(403, 'No puedes actualizar ninguna imagen de este recurso', 'IMAGEN_CREATE_FORBIDDEN');
        }

        if ($user->hasRole('periodista')) {
            $publicacion = Publicacion::where('usuarioIdCreacion', $user->id)->first();
            return $user->tokenCant("editar_imagen_publicacion_{$publicacion->id}")
                ?: Response::denyWithStatus(403, 'No puedes crear ninguna imagen en este recurso', 'IMAGEN_CREATE_FORBIDDEN');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Media $media): Response
    {
        if (!$user->hasPermissionTo('borrar_imagen')) return Response::denyWithStatus(403, 'No tienes permisos para borrar ninguna imagen', 'IMAGEN_DELETE_FORBIDDEN');

        if ($user->hasRole('entrenador')) {
            $equipo = $media->model();
            dd($equipo);
            return $user->tokenCant("borrar_imagen_equipo_{$equipo->id}") || $user->tokenCant("borrar_imagen_jugador_equipo_{$equipo->id}")
                ?: Response::denyWithStatus(403, "No puedes borrar ninguna imagen de este recurso", 'IMAGEN_DELETE_FORBIDDEN');
        }

        if ($user->hasRole('periodista')) {
            $publicacion = Publicacion::where('usuarioIdCreacion', $user->id)->first();
            return $user->tokenCant("borrar_imagen_publicacion_{$publicacion->id}")
                ?: Response::denyWithStatus(403, 'No puedes crear ninguna imagen en este recurso', 'IMAGEN_CREATE_FORBIDDEN');
        }

        return Response::allow();
    }
}
