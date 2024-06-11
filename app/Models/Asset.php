<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'description',
        'status',
        'location',
        'latitude',
        'longitude',
        'image_path',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
