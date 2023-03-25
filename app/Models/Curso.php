<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    public $table = "curso";
    protected $primaryKey = 'codigo_curso';
    use HasFactory;
    protected $fillable = [
        'nombre_curso',
        'fecha_inicio',
        'fecha_fin',
        'pvp_curso'
    ];
}
