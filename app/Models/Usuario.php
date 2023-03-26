<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $table = "usuario";
    protected $primaryKey = "dni";
    use HasFactory;
    protected $fillable = [
        'email',
        'telefono',
        'nombre',
        'apellidos',
        'fechaNacimiento',
        'password',
        'imagenPerfil'
    ];
}
