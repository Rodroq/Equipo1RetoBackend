<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserController;
use App\Http\Resources\UserResource;
use App\Models\Equipo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Login a specific user to use the API
     */
    /**
     * @OA\Post(
     *  path="/api/login",
     *  summary="registrar a un usuario en la web",
     *  description="Registrar a un usuario en la web para devolver su rol y su token con abilities",
     *  operationId="loginUser",
     *  tags={"login"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del usuario a loguearphp",
     *      @OA\JsonContent(
     *          required={"email","password"},
     *          @OA\Property(property="email", type="string", example="minillanillo@gmail.com"),
     *          @OA\Property(property="password", type="string", example="123"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response="200",
     *      description="Usuario logueado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Usuario logueado correctamente"),
     *          @OA\Property(
     *              property="data",
     *              type="object",
     *              @OA\Property(property="usuario", type="object", ref="#/components/schemas/Usuario"),
     *              @OA\Property(property="token", type="string", example="1|Token"),
     *          ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response="401",
     *      description="No autorizado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Credenciales incorrectas. Acceso no autorizado"),
     *      ),
     *  ),
     * )
     */
    public function login(LoginUserController $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        //creacion del token del usuario
        if ($user->hasRole('entrenador')) {
            $equipo = Equipo::where('usuarioIdCreacion', $user->id)->first();

            if (!$equipo) {
                $user->givePermissionTo('crear_equipo');
                $token = $user->createToken('token_usuario', [])->plainTextToken;
            } else {
                $user->givePermissionTo(['editar_equipo', 'borrar_equipo', 'crear_jugador', 'borrar_jugador', 'editar_jugador']);
                $jugadores_equipo = $equipo->jugadores()->count();
                $id_equipo = $equipo->id;
                $abilities = ["editar_equipo_{$id_equipo}", "borrar_equipo_{$id_equipo}", "actualizar_jugador_equipo_{$id_equipo}", "borrar_jugador_equipo_{$id_equipo}"];

                $jugadores_equipo < 12 ?: $abilities[] = "crear_jugador_equipo_{$id_equipo}";
                $token = $user->createToken('token_usuario', $abilities)->plainTextToken;
            }
        }

        if ($user->hasRole('administrador')) {
            $token = $user->createToken('token_usuario')->plainTextToken;
        }

        // Genera el token con las abilities dependiendo del rol del usuario
        return response()->json([
            'success' => true,
            'message' => 'Usuario logueado correctamente',
            'data' => ['usuario' => new UserResource($user), 'token' => $token],
        ], 200);
    }
}
