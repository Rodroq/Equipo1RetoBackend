<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearUsuarioRequest;
use App\Http\Requests\ActualizarUsuarioRequest;
use App\Http\Resources\UserResource;
use App\Mail\RegistroUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
            new Middleware('role:administrador'),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *  path="/api/usuarios",
     *  summary="Obtener todos los usuarios",
     *  description="Devuelve una lista de todos los usuarios registrados",
     *  operationId="indexUsuarios",
     *  tags={"usuarios"},
     *  security={{"bearerAuth": {}}},
     *  @OA\Response(
     *      response=200,
     *      description="Lista de usuarios",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Usuarios disponibles"),
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Usuario")),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No hay usuarios",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No hay usuarios"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="No autorizado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permisos para ver los usuarios"),
     *      ),
     *  ),
     * )
     */
    public function index()
    {
        $usuarios = User::all();

        return response()->json(['success' => true, 'message' => 'Usuarios disponibles', 'data' => UserResource::collection($usuarios),], 200);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *  path="/api/usuarios/{slug}",
     *  summary="Obtener un usuario específico",
     *  description="Devuelve los detalles de un usuario por Slug",
     *  operationId="showUsuario",
     *  tags={"usuarios"},
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del usuario",
     *      required=true,
     *      @OA\Schema(type="string"),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Detalles del usuario",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Usuario encontrado"),
     *          @OA\Property(property="usuario", type="object", ref="#/components/schemas/Usuario"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="No autorizado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permisos para ver este usuario"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Recurso no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="El recurso solicitado no fue encontrado")
     *      )
     *  )
     * )
     */
    public function show(User $usuario)
    {
        return response()->json(['success' => true, 'message' => 'Usuario encontrado', 'usuario' => new UserResource($usuario),], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *  path="/api/usuarios",
     *  summary="Crear un nuevo usuario",
     *  description="Registra un nuevo usuario en la base de datos",
     *  operationId="storeUsuario",
     *  tags={"usuarios"},
     *  security={{"bearerAuth": {}}},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del usuario",
     *      @OA\JsonContent(
     *          required={"name", "email", "password", "rol"},
     *          @OA\Property(property="name", type="string", example="Juan Perez"),
     *          @OA\Property(property="email", type="string", example="juan@example.com"),
     *          @OA\Property(property="password", type="string", example="password123"),
     *          @OA\Property(property="rol", type="string", example="entrenador"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Usuario creado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Usuario creado correctamente"),
     *          @OA\Property(property="data", type="object", ref="#/components/schemas/Usuario"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="No autorizado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permisos para crear usuarios"),
     *      ),
     *  ),
     * )
     */
    public function store(CrearUsuarioRequest $request)
    {
        $esAdmin = $this->user && $this->servicio_autenticacion->userHasRole($this->user, 'administrador');

        if (!$esAdmin) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para crear usuarios'], 403);
        }

        $usuario = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $usuario->syncRoles($request->rol);

        $mensaje = "
        Ha sido usted logueado satisfacoriamente en el torneo de la liga solidaria de la Cruz Roja <br/>
        Su contraseña de acceso es {$request->password}
        Su rol actual es {$request->rol}
        ";
        Mail::to($usuario->email)->send(new RegistroUsuario($usuario, $mensaje));

        return response()->json(['success' => true, 'message' => 'Usuario creado correctamente', 'usuarios' => new UserResource($usuario),], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *  path="/api/usuarios/{slug}",
     *  summary="Actualizar un usuario",
     *  description="Actualiza los datos de un usuario existente",
     *  operationId="updateUsuario",
     *  tags={"usuarios"},
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del usuario",
     *      required=true,
     *      @OA\Schema(type="string"),
     *  ),
     *  @OA\RequestBody(
     *      required=false,
     *      description="Datos del usuario a actualizar (todos los campos son opcionales)",
     *      @OA\JsonContent(
     *          @OA\Property(property="name", type="string", example="Juan Perez Actualizado"),
     *          @OA\Property(property="email", type="string", example="juan_actualizado@example.com"),
     *          @OA\Property(property="password", type="string", example="newpassword123"),
     *          @OA\Property(property="rol", type="string", example="administrador"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Usuario actualizado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Usuario actualizado correctamente"),
     *          @OA\Property(property="usuario", type="object", ref="#/components/schemas/Usuario"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Usuario no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Usuario no encontrado"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="No autorizado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permisos para actualizar este usuario"),
     *      ),
     *  ),
     * )
     */
    public function update(ActualizarUsuarioRequest $request, User $usuario)
    {
        $data = $request->only(['name', 'email', 'rol']);
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente', 'usuario' => new UserResource($usuario),], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *  path="/api/usuarios/{slug}",
     *  summary="Eliminar un usuario",
     *  description="Elimina un usuario por su Slug",
     *  operationId="destroyUsuario",
     *  tags={"usuarios"},
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      description="Slug del usuario",
     *      required=true,
     *      @OA\Schema(type="string"),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Usuario eliminado correctamente",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=true),
     *          @OA\Property(property="message", type="string", example="Usuario eliminado correctamente"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Usuario no encontrado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="Usuario no encontrado"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="No autorizado",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example=false),
     *          @OA\Property(property="message", type="string", example="No tienes permisos para eliminar este usuario"),
     *      ),
     *  ),
     * )
     */
    public function destroy(User $usuario)
    {
        $esAdmin = $this->user && $this->servicio_autenticacion->userHasRole($this->user, 'administrador');

        if (!$esAdmin) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para eliminar este usuario'], 403);
        }

        $usuario->delete();

        return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente'], 200);
    }
}
