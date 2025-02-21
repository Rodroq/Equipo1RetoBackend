<?php


namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\Equipo;
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

        if ($user->hasRole('administrador')) {
            $abilities = ['*'];
        }

        if ($user->hasRole('entrenador')) {
            $equipo = Equipo::where('usuarioIdCreacion', $user->id)->first();

            if (!$equipo) {
                $user->syncPermissions(['crear_equipo']);
            } else {
                $user->syncPermissions(['editar_equipo', 'borrar_equipo', 'crear_jugador', 'borrar_jugador', 'editar_jugador']);

                $id_equipo = $equipo->id;
                $abilities = [
                    "editar_equipo_{$id_equipo}",
                    "borrar_equipo_{$id_equipo}",
                    "actualizar_jugador_equipo_{$id_equipo}",
                    "borrar_jugador_equipo_{$id_equipo}"
                ];

                if ($equipo->jugadores()->count() < 12) {
                    $abilities[] = "crear_jugador_equipo_{$id_equipo}";
                }
            }
        }
        return $user->createToken('token_usuario', $abilities)->plainTextToken;
    }

    public function userHasRole(User $user, string $role)
    {
        return $user->hasRole($role);
    }
}
