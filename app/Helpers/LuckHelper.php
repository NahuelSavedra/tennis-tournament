<?php

namespace App\Helpers;

class LuckHelper
{
    public static function generateLuck($mean = 30, $std_dev = 5)
    {
        $u = mt_rand() / mt_getrandmax();
        $v = mt_rand() / mt_getrandmax();
        $z = sqrt(-2 * log($u)) * cos(2 * pi() * $v);
        return (int)($mean + $z * $std_dev);
    }

    public static function calculateLuck($player)
    {
        $baseLuck = self::generateLuck();
        $skillFactor = $player->skill_level * 0.1;
        return min(100, max(0, $baseLuck + $skillFactor));
    }

}
