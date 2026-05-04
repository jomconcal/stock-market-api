<?php

namespace App\Tests\Integration\FinnHub;

use App\Application\FinnHub\Mapper\GlobalQuote\QuoteEntityMapper;
use App\Application\FinnHub\Mapper\GlobalQuote\QuoteResponseMapper;
use App\Application\FinnHub\Response\QuoteResponse;
use App\Application\FinnHub\Service\QuoteService;
use App\Domain\FinnHub\VO\Ticker;
use App\Infrastructure\FinnHub\Persistence\QuoteRepository;
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
        $symbol = Ticker::create('AAPL');

        $json = file_get_contents(__DIR__.'/Fixtures/quotes_data.json');
        $data = json_decode($json, true);

        $quoteDto = QuoteResponseMapper::fromApi($data, $symbol);
        $quoteEntity = QuoteEntityMapper::fromDto($quoteDto);
        $fetchedAt = new \DateTimeImmutable()->modify('-14 minutes');
        $quoteEntity->setFetchedAt($fetchedAt);

        $this->quoteRepository->save($quoteEntity);

        $quoteResponse = $this->quoteService->execute($symbol->getSymbol());

        $expectedQuoteResponse = QuoteResponse::createFromCache($quoteDto);

        assertSame($expectedQuoteResponse->getSuccess(), $quoteResponse->getSuccess());
    }

    public function testUpdateEntityWhenRepeated(): void
    {
        $symbol = Ticker::create('AAPL');

        $json = file_get_contents(__DIR__.'/Fixtures/quotes_data.json');
        $data = json_decode($json, true);

        $quoteDto = QuoteResponseMapper::fromApi($data, $symbol);
        $quoteEntity = QuoteEntityMapper::fromDto($quoteDto);
        $fetchedAt = new \DateTimeImmutable()->modify('-16 minutes');
        $quoteEntity->setFetchedAt($fetchedAt);

        $this->quoteRepository->save($quoteEntity);

        $quoteResponse = $this->quoteService->execute($symbol->getSymbol());

        $expectedQuoteResponse = QuoteResponse::createFromUpdate($quoteDto);

        $updatedQuoteEntity = $this->quoteRepository->findOneBy([
            'symbol' => $symbol->getSymbol(),
        ]);

        assertNotNull($updatedQuoteEntity);
        self::assertTrue($fetchedAt < $updatedQuoteEntity->getFetchedAt());

        assertSame($expectedQuoteResponse->getSuccess(), $quoteResponse->getSuccess());
    }
}
