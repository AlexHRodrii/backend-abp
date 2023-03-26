<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public $table = "pedido";
    protected $primaryKey = 'numeroPedido';
    use HasFactory;
    protected $fillable = [
        'pvpTotal',
        'direccionEnvio',
        'fecha',
        'dni'
    ];
}
