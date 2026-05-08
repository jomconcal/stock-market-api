<?php

namespace App\Tests\Integration\FinnHub;

use App\Application\FinnHub\DTO\QuoteDto;
use App\Application\FinnHub\Service\QuoteService;
use App\Domain\FinnHub\Entity\QuoteEntity;
use App\Domain\FinnHub\VO\Ticker;
use App\Infrastructure\FinnHub\Persistence\QuoteRepository;
use App\Infrastructure\Parser\ValueParser;
use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertSame;

class GlobalQuoteServiceIntegrationTest extends KernelTestCase
{
    private QuoteService $quoteService;
    private QuoteRepository $quoteRepository;

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->quoteRepository = $container->get(QuoteRepository::class);
        $this->quoteService = $container->get(QuoteService::class);
    }

    public function testSaveUnexistingQuote(): void
    {
        $json = file_get_contents(__DIR__.'/Fixtures/quotes_data.json');
        $data = json_decode($json, true);
        $timeStamp = $data['t'];
        $lastUpdatedAt = \DateTimeImmutable::createFromFormat('U', $timeStamp);
        $symbol = 'AAPL';

        $quote = $this->quoteRepository->findBySymbolAndLastUpdate($symbol, $lastUpdatedAt);
        self::assertNull($quote);
        $this->quoteService->execute($symbol);

        $quote = $this->quoteRepository->findBySymbolAndLastUpdate($symbol, $lastUpdatedAt);
        self::assertNotNull($quote);
    }

    public function testRetrieveFromCache(): void
    {
        $ticker = Ticker::create('AAPL');

        $json = file_get_contents(__DIR__.'/Fixtures/quotes_data.json');
        $data = json_decode($json, true);

        $quoteEntity = $this->getQuoteFromData($ticker, $data);

        $fetchedAt = new \DateTimeImmutable()->modify('-14 minutes');
        $quoteEntity->setFetchedAt($fetchedAt);

        $this->quoteRepository->save($quoteEntity);

        $quoteResponse = $this->quoteService->execute($ticker->getSymbol());

        $expectedQuoteDto = QuoteDto::createFromCache($quoteEntity);

        assertSame($expectedQuoteDto->source, $quoteResponse->source);
    }

    public function testUpdateEntityWhenRepeated(): void
    {
        $ticker = Ticker::create('AAPL');

        $json = file_get_contents(__DIR__.'/Fixtures/quotes_data.json');
        $data = json_decode($json, true);

        $quoteEntity = $this->getQuoteFromData($ticker, $data);
        $fetchedAt = new \DateTimeImmutable()->modify('-16 minutes');
        $quoteEntity->setFetchedAt($fetchedAt);

        $this->quoteRepository->save($quoteEntity);

        $quoteDto = $this->quoteService->execute($ticker->getSymbol());

        $expectedQuoteDto = QuoteDto::createFromUpdate($quoteEntity);

        $updatedQuoteEntity = $this->quoteRepository->findOneBy([
            'symbol' => $ticker->getSymbol(),
        ]);

        assertNotNull($updatedQuoteEntity);
        self::assertTrue($fetchedAt < $updatedQuoteEntity->getFetchedAt());

        assertSame($expectedQuoteDto->source, $quoteDto->source);
    }

    private function getQuoteFromData(Ticker $ticker, array $data): QuoteEntity
    {
        $currentPrice = ValueParser::toFloat($data['c']);
        $change = ValueParser::toFloat($data['d']);
        $changePercent = ValueParser::toFloat($data['dp']);
        $high = ValueParser::toFloat($data['h']);
        $low = ValueParser::toFloat($data['l']);
        $open = ValueParser::toFloat($data['o']);
        $previousClose = ValueParser::toFloat($data['pc']);
        $timeStamp = ValueParser::toString($data['t']);
        $lastUpdate = \DateTimeImmutable::createFromFormat('U', $timeStamp);

        return new QuoteEntity(
            symbol: $ticker->getSymbol(),
            companyName: $ticker->getCompanyName(),
            currentPrice: $currentPrice,
            priceChange: $change,
            changePercent: $changePercent,
            high: $high,
            low: $low,
            open: $open,
            previousClose: $previousClose,
            lastUpdate: $lastUpdate,
        );
    }
}
