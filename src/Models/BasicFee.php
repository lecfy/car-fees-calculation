<?php

namespace App\Models;

use App\Models\FeeInterface;

class BasicFee implements FeeInterface
{

    public function getName(): string
    {
        return "basic_fee";
    }

    public function calculatePrice(Vehicle $vehicle): float
    {
        $base = $vehicle->price / 100 * 10;

        $min = $vehicle->isLuxury ? 25 : 10;
        $max = $vehicle->isLuxury ? 200 : 50;

        return min(max($base, $min), $max);
    }
}