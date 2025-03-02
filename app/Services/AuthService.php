<?php


namespace App\Services;

use App\Models\Acta;
use Illuminate\Support\Facades\Hash;
use App\Models\Equipo;
use App\Models\Partido;
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
            $equipo = Equipo::where('usuarioIdCreacion', $user->id)->first();

            if (!$equipo) {
                $user->syncPermissions(['crear_equipo']);
            } else {
                $user->syncPermissions(['editar_equipo', 'borrar_equipo', 'editar_jugador', 'borrar_jugador', 'crear_imagen', 'editar_imagen', 'borrar_imagen']);

                if ($equipo->jugadores()->count() < 12) {
                    $user->givePermissionTo('crear_jugador');
                }

                $id_equipo = $equipo->id;
                $abilities = [
                    "editar_equipo_{$id_equipo}",
                    "borrar_equipo_{$id_equipo}",
                    "crear_imagen_equipo_{$id_equipo}",
                    "editar_imagen_equipo_{$id_equipo}",
                    "borrar_imagen_equipo_{$id_equipo}",
                    "editar_jugador_equipo_{$id_equipo}",
                    "borrar_jugador_equipo_{$id_equipo}",
                    "crear_imagen_jugador_equipo_{$id_equipo}",
                    "editar_imagen_jugador_equipo_{$id_equipo}",
                    "borrar_imagen_jugador_equipo_{$id_equipo}"
                ];
            }
        }

        if ($this->userHasRole($user, 'director')) {
            $user->syncPermissions([/* 'crear_partido','borrar_partido', */'crear_acta', 'leer_acta', 'editar_acta', 'borrar_acta']);

            $actas_director = Acta::where('usuarioIdCreacion', $user->id)->get();
            foreach ($actas_director as $acta) {
                array_push(
                    $abilities,
                    "editar_acta_{$acta->id}",
                    "borrar_acta_{$acta->id}"
                );
            }

            /* $partidos_director = Partido::where('usuarioIdCreacion', $user->id)->get();
            foreach ($partidos_director as $partido) {
                array_push(
                    $abilities,
                    "editar_partido_{$partido->id}",
                    "borrar_partido_{$partido->id}",
                    "crear_imagen_partido_{$partido->id}",
                    "editar_imagen_partido_{$partido->id}",
                    "borrar_imagen_partido_{$partido->id}"
                );
            } */
        }

        if ($this->userHasRole($user, 'periodista')) {
            $user->syncPermissions(['crear_publicacion', 'editar_publicacion', 'borrar_publicacion', 'crear_imagen', 'editar_imagen', 'borrar_imagen']);

            $publicaciones_periodista = Publicacion::where('usuarioIdCreacion', $user->id)->get();
            foreach ($publicaciones_periodista as $publicacion) {
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

        return $user->createToken('token_usuario', $abilities)->plainTextToken;
    }

    public function userHasRole(User $user, string $role)
    {
        return $user->hasRole($role);
    }
}
