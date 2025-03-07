<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Donaciones",
 *     title="donaciones",
 *     description="Modelo de donaciones",
 *     @OA\Property(property="id", type="integer", description="ID de la donación", example=1),
 *     @OA\Property(property="kilos", type="integer", description="Cantidad de kilos donados", example=50),
 *     @OA\Property(property="importe", type="number", format="float", description="Importe de la donación", example=150.75),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación", example="2025-03-03T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Última actualización", example="2025-03-03T12:34:56Z")
 * )
 */
class Donaciones extends Model
{
    protected $table = "donaciones";

    protected $fillable = [
        'kilos',
        'importe'
    ];
}
