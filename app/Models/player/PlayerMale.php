<?php

namespace App\Models\player;

use App\Models\Player;

class PlayerMale extends Player
{
    public function calculateScore(): int
    {
        return parent::calculateScore() + $this->strength + $this->reaction_time;
    }
}
