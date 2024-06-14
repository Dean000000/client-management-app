<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'description', 'location', 'latitude', 'longitude', 'image_path'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
