<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    use HasFactory;
    public function wedding()
    {
        return $this->hasMany(Wedding::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
