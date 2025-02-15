<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *@OA\Schema(
 *  schema="Centro",
 *  type="object",
 *  title="Centro",
 *  required={"nombre"},
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
