<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenCurso extends Model
{
    public $table = "imagenCurso";
    protected $primaryKey = 'codigoCurso';
    use HasFactory;
    protected $fillable = [
        'referenciaCurso',
        'url'
    ];
}
