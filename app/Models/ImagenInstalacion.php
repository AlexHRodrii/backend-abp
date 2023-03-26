<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenInstalacion extends Model
{
    public $table = "imagenInstalacion";
    protected $primaryKey = 'codigoImagen';
    use HasFactory;
    protected $fillable = [
        'referenciaInstalacion',
        'url'
    ];
}
