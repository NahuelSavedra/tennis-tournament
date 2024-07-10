<?php

namespace App\Models;

use App\Helpers\LuckHelper;
use App\Models\player\PlayerFemale;
use App\Models\player\PlayerMale;
use App\ScoringPlayerInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model implements ScoringPlayerInterface
{
    use HasFactory;

    protected $table = 'players';

    protected $fillable = ['name', 'skill_level','speed', 'strength',' reaction_time'];

    public function getClass(): PlayerMale|PlayerFemale
    {
        if ($this->gender === 'male') {
            return new PlayerMale($this->attributes);
        } else {
            return new PlayerFemale($this->attributes);
        }
    }

    public function games()
    {
        return $this->hasMany(Game::class, 'player1_id')
            ->orWhere('player2_id', $this->id);
    }

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class);
    }

    public function calculateScore(): int
    {
        return $this->skill_level; // Base score
    }

    public function calculateLuck(): int
    {
        return LuckHelper::calculateLuck($this);
    }
}
