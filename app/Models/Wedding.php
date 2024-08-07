<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    use HasFactory;
    protected $hidden = [
        'created_at',
        'updated_at',
        'packet_id',
        'packet_custom_id',
    ];

    public function packet()
    {
        return $this->belongsTo(Packet::class);
    }

    public function packetCustom()
    {
        return $this->belongsTo(PacketCustom::class);
    }

    public function task()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
