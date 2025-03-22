<?php

namespace App\Models;

use App\Models\FeeInterface;

class SpecialFee implements FeeInterface
{

    public function getName(): string
    {
        return "special_fee";
    }

    public function calculatePrice(Vehicle $vehicle): float
    {
        $percent = $vehicle->isLuxury ? 4 : 2;

        return $vehicle->price / 100 * $percent;
    }
}