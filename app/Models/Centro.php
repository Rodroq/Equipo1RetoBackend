<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *@OA\Schema(
 *  schema="Centro",
 *  type="object",
 *  title="Centro",
 *  required={"id", "nombre"},
 *  @OA\Property(property="id", type="integer", example=1),
 *  @OA\Property(property="nombre", type="string", example="IES Ejemplo"),
 *)
 */
class Centro extends Model
{
    protected $table = 'centros';


    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function estudios()
    {
        return $this->hasMany(Estudio::class);
    }
}
