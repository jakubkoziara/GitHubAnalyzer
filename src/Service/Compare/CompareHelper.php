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

    public function checkLastDate(\DateTime $firstDate, \DateTime $secondDate): bool
    {
        return $firstDate > $secondDate;
    }

    public function checkSameDate(\DateTime $firstDate, \DateTime $secondDate): bool
    {
        return $firstDate == $secondDate;
    }
}