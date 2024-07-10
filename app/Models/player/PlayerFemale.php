<?php

namespace App\Models\player;

use App\Models\Player;

class PlayerFemale extends Player
{
    private $speed;

    public function calculateScore(): int
    {
        return parent::calculateScore() + $this->speed;
    }
}
