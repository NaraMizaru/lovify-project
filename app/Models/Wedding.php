<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    use HasFactory;
    public function packet()
    {
        return $this->belongsTo(Packet::class);
    }

    public function packetCustom()
    {
        return $this->belongsTo(PacketCustom::class);
    }
}
