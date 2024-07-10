<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }
}
