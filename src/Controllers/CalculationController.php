<?php

namespace App\Controllers;

use App\Models\AssociationFee;
use App\Models\BasicFee;
use App\Models\SpecialFee;
use App\Models\StorageFee;
use App\Models\Vehicle;
use App\Services\CalculationService;

class CalculationController
{
    private CalculationService $calculationService;

    public function __construct()
    {
        $this->calculationService = new CalculationService();

        $this->calculationService->addFee(new BasicFee());
        $this->calculationService->addFee(new SpecialFee());
        $this->calculationService->addFee(new AssociationFee());
        $this->calculationService->addFee(new StorageFee());
    }

    private function calculate(float $price, string $type): array
    {
        $vehicle = new Vehicle($price, $type);
        return $this->calculationService->calculateTotalPrice($vehicle);
    }

    public function processApiRequest(): void
    {
        $inputData = json_decode(file_get_contents('php://input'), true);

        if (empty($inputData['price']) or empty($inputData['type'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Required fields missing']);
            return;
        }

        $price = (float) $inputData['price'];

        if ($price <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid price']);
            return;
        }

        if (!in_array($inputData['type'], [Vehicle::COMMON_TYPE, Vehicle::LUXURY_TYPE])) {
            http_response_code(400);
            echo json_encode(['error' => 'Type not permitted']);
            return;
        }

        $result = $this->calculate($price, $inputData['type']);

        header('Content-Type: application/json');
        echo json_encode($result);

    }

}