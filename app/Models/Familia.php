<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *@OA\Schema(
 *  schema="Familia",
 *  type="object",
 *  title="Familia",
 *  required={"nombre"},
 *  @OA\Property(property="nombre", type="string", example="Textil, Confección y Piel"),
 *)
 */
class Familia extends Model
{
    protected $table = 'familias';
}
