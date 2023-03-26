<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    public $table = "curso";
    protected $primaryKey = 'codigoCurso';
    use HasFactory;
    protected $fillable = [
        'nombreCurso',
        'fechaInicio',
        'fechaFin',
        'pvpCurso'
    ];
}
