<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    public function weddding()
    {
        return $this->belongsTo(Wedding::class);
    }

    public $timestamps = false;
}
