<?php

namespace App\Models;

class StorageFee implements FeeInterface
{
    public function getName(): string
    {
        return 'storage_fee';
    }

    public function calculatePrice(Vehicle $vehicle): float
    {
        return 100;
    }
}