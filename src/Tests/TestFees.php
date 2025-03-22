<?php
namespace App\Tests;

use App\Models\AssociationFee;
use App\Models\BasicFee;
use App\Models\SpecialFee;
use App\Models\StorageFee;
use App\Models\Vehicle;
use App\Services\CalculationService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TestFees extends TestCase
{
    private CalculationService $calculationService;

    public function testTrueIsTrue()
    {
        $this->assertTrue(true);
    }

    protected function setUp(): Void
    {
        $this->calculationService = new CalculationService();

        $this->calculationService->feesList[] = new BasicFee();
        $this->calculationService->feesList[] = new SpecialFee();
        $this->calculationService->feesList[] = new AssociationFee();
        $this->calculationService->feesList[] = new StorageFee();
    }

    public function testVehicle(): void
    {
        $vehicle = new Vehicle(1000, Vehicle::COMMON_TYPE);
        $this->assertEquals(1000, $vehicle->price);
        $this->assertEquals(Vehicle::COMMON_TYPE, $vehicle->type);
        $this->assertFalse($vehicle->isLuxury);

        $vehicle = new Vehicle(10000, Vehicle::LUXURY_TYPE);
        $this->assertEquals(10000, $vehicle->price);
        $this->assertEquals(Vehicle::LUXURY_TYPE, $vehicle->type);
        $this->assertTrue($vehicle->isLuxury);
    }

    public function testBasicFee(): void
    {
        $basicFee = new BasicFee();

        // common vehicle, minimum fee $10
        $vehicle = new Vehicle(100, Vehicle::COMMON_TYPE);
        $this->assertEquals(10, $basicFee->calculatePrice($vehicle));
    }


    #[DataProvider('provider')] public function testCalculation(float $price, string $type, array $fees, float $total): void
    {
        $vehicle = new Vehicle($price, $type);
        $calculations = $this->calculationService->calculateTotalPrice($vehicle);

        $this->assertEquals($total, $calculations['total']);
        $this->assertEquals($price, $calculations['vehiclePrice']);
        $this->assertEquals($fees['basic_fee'], $calculations['feesList']['basic_fee']);
        $this->assertEquals($fees['special_fee'], $calculations['feesList']['special_fee']);
        $this->assertEquals($fees['association_fee'], $calculations['feesList']['association_fee']);
        $this->assertEquals($fees['storage_fee'], $calculations['feesList']['storage_fee']);

    }

    public static function provider(): array
    {
        return [
            [
                398.00,
                Vehicle::COMMON_TYPE,
                [
                    'basic_fee' => 39.80,
                    'special_fee' => 7.96,
                    'association_fee' => 5.00,
                    'storage_fee' => 100.00
                ],
                550.76
            ],

            [
                501.00,
                Vehicle::COMMON_TYPE,
                [
                    'basic_fee' => 50.00,
                    'special_fee' => 10.02,
                    'association_fee' => 10.00,
                    'storage_fee' => 100.00
                ],
                671.02
            ],

            [
                57.00,
                Vehicle::COMMON_TYPE,
                [
                    'basic_fee' => 10.00,
                    'special_fee' => 1.14,
                    'association_fee' => 5.00,
                    'storage_fee' => 100.00
                ],
                173.14
            ],

            [
                1800.00,
                Vehicle::LUXURY_TYPE,
                [
                    'basic_fee' => 180.00,
                    'special_fee' => 72.00,
                    'association_fee' => 15.00,
                    'storage_fee' => 100.00
                ],
                2167.00
            ],

            [
                1100.00,
                Vehicle::COMMON_TYPE,
                [
                    'basic_fee' => 50.00,
                    'special_fee' => 22.00,
                    'association_fee' => 15.00,
                    'storage_fee' => 100.00
                ],
                1287.00
            ],

            [
                1000000.00,
                Vehicle::LUXURY_TYPE,
                [
                    'basic_fee' => 200.00,
                    'special_fee' => 40000.00,
                    'association_fee' => 20.00,
                    'storage_fee' => 100.00
                ],
                1040320.00
            ],
        ];
    }
}