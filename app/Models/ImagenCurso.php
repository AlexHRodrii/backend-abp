<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenCurso extends Imagen
{
    public $table = "imagenCurso";
    use HasFactory;

    public $referenciaCurso = 'referenciaCurso';
    public function __construct($primaryKey, $url, $referenciaCurso)
    {
        parent::__construct($primaryKey, $url);
        $this->referenciaCurso = $referenciaCurso;
    }
}
