<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public $table = "pedido";
    protected $primaryKey = 'numero_pedido';
    use HasFactory;
    protected $fillable = [
        'pvp_total',
        'direccion_envio',
        'fecha',
        'dni'
    ];
}
