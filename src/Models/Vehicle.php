<?php

namespace App\Models;

class Vehicle
{
    public readonly float $price;
    public readonly string $type;

    public bool $isLuxury {
        get {
            return $this->type === self::LUXURY_TYPE;
        }
    }

    const string COMMON_TYPE = 'Common';
    const string LUXURY_TYPE = 'Luxury';

    public function __construct(float $price, string $type)
    {
        $this->price = $price;
        $this->type = $type;
    }

}