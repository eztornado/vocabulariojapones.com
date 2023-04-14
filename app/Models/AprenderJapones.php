<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AprenderJapones extends Model
{
    protected $table = 'aprender_japones';
    protected $fillable = [
        'original',
        'traducido',
        'acertado',
        'fallado',
        'visto',
        'hiragana',
    ];

}
