<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalacion extends Model
{
    public $table = "instalacion";
    protected $primaryKey = 'codigoInstalacion';
    use HasFactory;
    protected $fillable = [
        'nombreInstalacion',
        'descripcionInstalacion',
        'pvpHora',
        'deporteAsociado',
    ];
}
