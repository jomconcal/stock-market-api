<?php

declare(strict_types=1);

namespace App\Tests\Unit\AlphaVantage;

use App\Domain\AlphaVantage\VO\Symbol;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SymbolUnitTest extends TestCase
{
    #[DataProvider('validSymbolsProvider')]
    public function testItCreatesValidSymbols(string $input): void
    {
        $symbol = Symbol::create($input);

        $this->assertSame(trim(strtoupper($input)), $symbol->value());
    }

    #[DataProvider('invalidSymbolsProvider')]
    public function testItThrowsExceptionForInvalidSymbols(string $input): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Symbol::create($input);
    }

    public static function validSymbolsProvider(): array
    {
        return [
            ['AAPL '],
            ['msft'],
            ['GOOG'],
            ['AMZN'],
            ['NVDA'],
            ['META'],
            ['TSLA'],
            ['TM'],
            ['XOM'],
            ['SHEL'],
            ['JPM'],
            ['GS'],
            ['V'],
            ['KO'],
            ['PEP'],
            ['WMT'],
            ['NKE'],
            ['ITX.MAD'],
            ['SAN.MAD'],
            ['BBVA.MAD'],
            ['IBE.MAD'],
        ];
    }

    public static function invalidSymbolsProvider(): array
    {
        return [
            [''],
            ['INVALID'],
            ['GOOGL'],
            ['123'],
            ['TESLA'],
            ['ITX'],
        ];
    }
}
