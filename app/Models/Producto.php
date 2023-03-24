<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $table = "producto";
    protected $primaryKey = 'codigo_producto';
    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcion_producto',
        'pvp',
        'stock',
        'categoria'
    ];
}
