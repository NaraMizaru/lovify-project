<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function venuePackets()
    {
        return $this->hasMany(Packet::class, 'venue_id');
    }

    public function cateringPackets()
    {
        return $this->hasMany(Packet::class, 'catering_id');
    }

    public function decorationPackets()
    {
        return $this->hasMany(Packet::class, 'decoration_id');
    }

    public function photographerPackets()
    {
        return $this->hasMany(Packet::class, 'photographer_id');
    }

    public function muaPackets()
    {
        return $this->hasMany(Packet::class, 'mua_id');
    }

    public function venuePacketsCustom()
    {
        return $this->hasMany(Packet::class, 'venue_id');
    }

    public function cateringPacketsCustom()
    {
        return $this->hasMany(Packet::class, 'catering_id');
    }

    public function decorationPacketsCustom()
    {
        return $this->hasMany(Packet::class, 'decoration_id');
    }

    public function photographerPacketsCustom()
    {
        return $this->hasMany(Packet::class, 'photographer_id');
    }

    public function muaPacketsCustom()
    {
        return $this->hasMany(Packet::class, 'mua_id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function vendorAttachment()
    {
        return $this->hasMany(VendorAttachment::class);
    }
}
