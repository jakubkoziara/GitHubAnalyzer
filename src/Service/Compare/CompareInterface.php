<?php


namespace App\Service\Compare;


interface CompareInterface
{
    public function compare(array $gitHubData);
}