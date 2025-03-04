<?php


namespace App\Services;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\Equipo;
use App\Models\Publicacion;
use App\Models\User;

final class AuthService
{

    public function authenticateUser($credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return ['status' =>  401, 'success' => false, 'message' => 'Credenciales incorrectas'];
        }

        return ['success' => true, 'user' => $user, 'token' => $this->generateUserToken($user)];
    }

    public function generateUserToken(User $user)
    {
        $user->tokens()->delete();
        $abilities = [];

        if ($this->userHasRole($user, 'administrador')) {
            $abilities = ['*'];
        }

        if ($this->userHasRole($user, 'entrenador')) {
            $this->handleEntrenadorPermissions($user, $abilities);
        }

        if ($this->userHasRole($user, 'director')) {
            $user->syncPermissions('crear_acta');
        }

        if ($this->userHasRole($user, 'periodista')) {
            $this->handlePeriodistaPermissions($user, $abilities);
        }

        return $user->createToken('token_usuario', $abilities)->plainTextToken;
    }

    public function regenerateUserToken(User $user)
    {
        $this->generateUserToken($user);
        return ['success' => true, 'user' => new UserResource($user), 'token' => $this->generateUserToken($user)];
    }

    public function userHasRole(User $user, string $role)
    {
        return $user->hasRole($role);
    }

    private function handleEntrenadorPermissions(User $user, array &$abilities)
    {
        $equipo = Equipo::where('usuarioIdCreacion', $user->id)->first();

        if (!$equipo) {
            $user->syncPermissions(['crear_equipo']);
        } else {
            $user->syncPermissions([
                'editar_equipo',
                'borrar_equipo',
                'editar_jugador',
                'borrar_jugador',
                'crear_patrocinador',
                'borrar_patrocinador',
                'crear_imagen',
                'editar_imagen',
                'borrar_imagen'
            ]);

            if ($equipo->jugadores()->count() < 12) {
                $user->givePermissionTo('crear_jugador');
            }

            $id_equipo = $equipo->id;
            $abilities = array_merge($abilities, [
                "editar_equipo_{$id_equipo}",
                "borrar_equipo_{$id_equipo}",
                "crear_imagen_equipo_{$id_equipo}",
                "editar_imagen_equipo_{$id_equipo}",
                "borrar_imagen_equipo_{$id_equipo}",
                "editar_jugador_equipo_{$id_equipo}",
                "borrar_jugador_equipo_{$id_equipo}",
                "crear_imagen_jugador_equipo_{$id_equipo}",
                "editar_imagen_jugador_equipo_{$id_equipo}",
                "borrar_imagen_jugador_equipo_{$id_equipo}",
                "crear_patrocinador_equipo_{$id_equipo}",
                "borrar_patrocinador_equipo_{$id_equipo}",
                "crear_imagen_patrocinador_equipo_{$id_equipo}",
                "editar_imagen_patrocinador_equipo_{$id_equipo}",
                "borrar_imagen_patrocinador_equipo_{$id_equipo}"
            ]);
        }
    }

    private function handlePeriodistaPermissions(User $user, array &$abilities)
    {
        $user->syncPermissions([
            'crear_publicacion',
            'editar_publicacion',
            'borrar_publicacion',
            'crear_imagen',
            'editar_imagen',
            'borrar_imagen'
        ]);

        $publicaciones = Publicacion::where('usuarioIdCreacion', $user->id)->get();
        foreach ($publicaciones as $publicacion) {
            array_push(
                $abilities,
                "editar_publicacion_{$publicacion->id}",
                "borrar_publicacion_{$publicacion->id}",
                "crear_imagen_publicacion_{$publicacion->id}",
                "editar_imagen_publicacion_{$publicacion->id}",
                "borrar_imagen_publicacion_{$publicacion->id}"
            );
        }
    }
}
