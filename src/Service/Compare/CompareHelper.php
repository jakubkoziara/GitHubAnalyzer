<?php
declare(strict_types=1);


namespace App\Service\Compare;


class CompareHelper
{
    public function checkEquals(int $firstNumber, int $secondNumber): bool
    {
        return $firstNumber === $secondNumber;
    }

    public function checkGreaterThan(int $firstNumber, int $secondNumber): bool
    {
        return $firstNumber > $secondNumber;
    }
}