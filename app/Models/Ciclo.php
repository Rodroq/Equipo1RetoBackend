<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *@OA\Schema(
 *  schema="Ciclo",
 *  type="object",
 *  title="Ciclo",
 *  required={"nombre"},
 *  @OA\Property(property="nombre", type="string", example="FPGB Tapicería y Cortinaje"),
 *  @OA\Property(property="familia", type="object", ref="#/components/schemas/Familia"),
 *)
 */
class Ciclo extends Model
{
    protected $table = 'ciclos';

    public function estudio()
    {
        return $this->belongsTo(Estudio::class);
    }

    public function familia(){
        return $this->belongsTo(Familia::class);
    }
}
