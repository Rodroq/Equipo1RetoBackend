<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 *@OA\Schema(
 *  schema="Estudio",
 *  type="object",
 *  title="Estudio",
 *  @OA\Property(property="centro", type="string", example="IES Ejemplo"),
 *  @OA\Property(property="curso", type="integer", example=1),
 *  @OA\Property(property="ciclos", type="object", ref="#/components/schemas/Ciclo"),
 *)
 */
class Estudio extends Model
{
    protected $table = 'estudios';

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    public function jugadores()
    {
        return $this->hasMany(Jugador::class);
    }

    public function ciclo(){
        return $this->belongsTo(Ciclo::class);
    }
}
