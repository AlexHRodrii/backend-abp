<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    public $table = "Imagen";

    public $primaryKey = 'codigo_imagen';
    public $url = 'url';
    public function __construct($primaryKey, $url){
        $this->primaryKey = $primaryKey;
        $this->url = $url;
    }
}
