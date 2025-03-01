<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @OA\Info(title="API Torneo Solidario", version="1.0",description="API del torneo solidario",
 * @OA\Server(url="http://localhost:8000"),
 * @OA\Contact(email="minillanillo@gmail.com")),
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Use a token to authenticate",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth",
 * ),
 */
abstract class Controller
{

    protected AuthService $servicio_autenticacion;
    protected ImageService $servicio_imagenes;
    protected ?User $user;

    public function __construct(AuthService $servicio_autenticacion, ImageService $servicio_imagenes)
    {
        $this->servicio_autenticacion = $servicio_autenticacion;
        $this->servicio_imagenes = $servicio_imagenes;
        $this->user = Auth::user();
    }

    protected function getModelInstance(string $model, ?string $slug = null)
    {
        $className = Relation::getMorphedModel($model);

        if (!class_exists($className)) {
            throw new NotFoundHttpException();
        }

        return $slug ? $className::where('slug', $slug)->first() : new $className;
    }
}
