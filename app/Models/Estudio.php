<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 *@OA\Schema(
 *  schema="Estudio",
 *  type="object",
 *  title="Estudio",
 *  @OA\Property(property="id", type="integer", example=1),
 *  @OA\Property(property="curso", type="integer", example=1),
 *)
 */
class Estudio extends Model
{
    protected $table = 'estudios';

    public function centros()
    {
        return $this->belongsTo(Centro::class);
    }

    public function jugadores()
    {
        return $this->hasMany(Jugador::class);
    }
}
