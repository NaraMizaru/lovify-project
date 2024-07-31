<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketCustom extends Model
{
    use HasFactory;
    public function weddding()
    {
        return $this->belongsTo(Wedding::class);
    }

    public function venue()
    {
        return $this->belongsTo(Vendor::class, 'venue_id');
    }

    public function decoration()
    {
        return $this->belongsTo(Vendor::class, 'decoration_id');
    }

    public function catering()
    {
        return $this->belongsTo(Vendor::class, 'catering_id');
    }

    public function photographer()
    {
        return $this->belongsTo(Vendor::class, 'photographer_id');
    }

    public function mua()
    {
        return $this->belongsTo(Vendor::class, 'mua_id');
    }
}
