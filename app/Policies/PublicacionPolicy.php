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
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Publicacion $publicacion): Response
    {
        return false;
    }
}
