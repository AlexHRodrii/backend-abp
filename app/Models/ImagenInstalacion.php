<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenInstalacion extends Imagen
{
    public $table = "imagenInstalacion";
    use HasFactory;

    public $referenciaInstalacion = 'referenciaInstalacion';
    public function __construct($primaryKey, $url, $referenciaInstalacion)
    {
        parent::__construct($primaryKey, $url);
        $this->referenciaInstalacion = $referenciaInstalacion;
    }
}
