<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Imagen
{
    public $table = "imagenProducto";
    use HasFactory;

    public $referenciaProducto = 'referenciaProducto';
    public function __construct($primaryKey, $url, $referenciaProducto)
    {
        parent::__construct($primaryKey, $url);
        $this->referenciaProducto = $referenciaProducto;
    }
}
