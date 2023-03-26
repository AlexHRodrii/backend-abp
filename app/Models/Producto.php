<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $table = "producto";
    protected $primaryKey = 'codigoProducto';
    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcionProducto',
        'pvp',
        'stock',
        'categoria'
    ];
}
