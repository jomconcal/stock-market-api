<?php

namespace App\Domain\AlphaVantage\Repository;

use App\Domain\AlphaVantage\Entity\AlphaVantageLog;

interface AlphaVantageLogRepositoryInterface
{
    public function save(AlphaVantageLog $alphaVantageLog): void;
}
