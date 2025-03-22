<?php

namespace App\Services;

use App\Models\FeeInterface;
use App\Models\Vehicle;

class CalculationService
{
    private array $feesList = [];

    public function addFee(FeeInterface $fee): void
    {
        $this->feesList[] = $fee;
    }

    public function calculateTotalPrice(Vehicle $vehicle): array
    {
        $feesList = [];
        $feesTotal = 0;

        foreach ($this->feesList as $fee) {
            $feeAmount = $fee->calculatePrice($vehicle);
            $feesList[$fee->getName()] = $feeAmount;
            $feesTotal += $feeAmount;
        }

        return [
            'vehiclePrice' => $vehicle->price,
            'feesList' => $feesList,
            'feesTotal' => $feesTotal,
            'total' => $vehicle->price + $feesTotal
        ];
    }

}