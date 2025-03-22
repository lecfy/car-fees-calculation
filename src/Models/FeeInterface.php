<?php

namespace App\Models;

interface FeeInterface
{
    public function getName(): string;

    public function calculatePrice(Vehicle $vehicle): float;
}