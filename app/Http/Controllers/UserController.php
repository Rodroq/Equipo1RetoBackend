<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Usuario")),
     *      ),
     *  ),
     *  @OA\Response(
     *      response="403",
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
                'message' => 'Credenciales incorrectas. Acceso no autorizado'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario logueado correctamente',
            'data' => new UserResource($user),
        ], 200);
    }
}
