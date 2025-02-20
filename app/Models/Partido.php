<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Partido",
 * type="object",
 * title="Partido",
 * required={"fecha", "hora", "equipoLoc", "golesVis", "pabellon"},
 * @OA\Property(property="fecha", type="string", example="2021-10-10"),
 * @OA\Property(property="hora", type="string", format="time", example="16:00:00"),
 * @OA\Property(property="equipoLoc", type="integer", example=1),
 * @OA\Property(property="equipoVis", type="integer", example=2),
 * )
 */
class Partido extends Model
{
    protected $table = 'partidos';

    protected $fillable = [
        'fecha',
        'hora',
        'golesL',
        'golesV',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion',
        'equipoL',
        'equipoV',
        'pabellon_id'
    ];

    public function actas()
    {
        return $this->hasMany(Acta::class);
    }

    public function equipoLoc()
    {
        return $this->belongsTo(Equipo::class, 'equipoL');
    }

    public function equipoVis()
    {
        return $this->belongsTo(Equipo::class, 'equipoV');
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function pabellon()
    {
        return $this->belongsTo(Pabellon::class);
    }
}
?>