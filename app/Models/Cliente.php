<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Cliente extends Eloquent
{
    protected $fillable = ['nombre', 'telefono', 'notas'];
}
