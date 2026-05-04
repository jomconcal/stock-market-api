<?php

declare(strict_types=1);

namespace App\Tests\Unit\FinnHub;

use App\Domain\FinnHub\VO\Ticker;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SymbolUnitTest extends TestCase
{
    #[DataProvider('validSymbolsProvider')]
    public function testItCreatesValidSymbols(string $input): void
    {
        $symbol = Ticker::create($input);

        $this->assertSame(trim(strtoupper($input)), $symbol->getSymbol());
    }

    #[DataProvider('invalidSymbolsProvider')]
    public function testItThrowsExceptionForInvalidSymbols(string $input): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Ticker::create($input);
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
            ['ITX.MC'],
            ['SAN.MC'],
            ['BBVA.MC'],
            ['IBE.MC'],
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
