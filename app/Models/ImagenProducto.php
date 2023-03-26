<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    public $table = "imagenProducto";
    protected $primaryKey = 'codigoImagen';
    use HasFactory;
    protected $fillable = [
        'referenciaProducto',
        'url'
    ];
}
