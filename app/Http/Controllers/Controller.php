<?php

namespace App\Http\Controllers;

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
}
