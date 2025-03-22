<?php

namespace App\Models;

use App\Models\FeeInterface;

class AssociationFee implements FeeInterface
{

    public function getName(): string
    {
        return "association_fee";
    }

    public function calculatePrice(Vehicle $vehicle): float
    {
        if ($vehicle->price <= 500) {
            return 5;
        } elseif ($vehicle->price <= 1000) {
            return 10;
        } elseif ($vehicle->price <= 3000) {
            return 15;
        } else {
            return 20;
        }
    }
}