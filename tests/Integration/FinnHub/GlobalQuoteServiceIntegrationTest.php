<?php

namespace App\Tests\Integration\FinnHub;

use App\Application\FinnHub\Mapper\GlobalQuote\GlobalQuoteEntityMapper;
use App\Application\FinnHub\Mapper\GlobalQuote\QuoteResponseMapper;
use App\Application\FinnHub\Service\GlobalQuoteService;
use App\Domain\FinnHub\Client\FinnHubClientInterface;
use App\Infrastructure\FinnHub\Persistence\GlobalQuoteRepository;
use App\Tests\Mocks\FinnHubClientMock;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class GlobalQuoteServiceIntegrationTest extends KernelTestCase
{
    private GlobalQuoteService $globalQuoteService;
    private GlobalQuoteRepository $globalQuoteRepository;
    private FinnHubClientMock $finnHubClient;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->globalQuoteRepository = $container->get(GlobalQuoteRepository::class);
        $this->globalQuoteService = $container->get(GlobalQuoteService::class);
        $this->finnHubClient = $container->get(FinnHubClientInterface::class);
    }

    public function testNotFetchedToday(): void
    {
        $this->saveData();

        $symbol = 'GOOG';
        $globalQuote = $this->globalQuoteRepository->findByFetchedTodayAndSymbol($symbol);
        $this->assertNull($globalQuote);

        $this->globalQuoteService->execute($symbol);
        $globalQuote = $this->globalQuoteRepository->findByFetchedTodayAndSymbol($symbol);
        $this->assertNotNull($globalQuote);
    }

    public function testNotFetchedTodayButLatestTradingDayExistsInDB(): void
    {
        $this->saveData();

        $symbol = 'AAPL';

        $latestTradingDay = $this->finnHubClient->getLatestTradingDay();

        $globalQuote = $this->globalQuoteRepository->getBySymbolAndLatestTradingDay(
            $symbol,
            $latestTradingDay
        );

        assertNotNull($globalQuote);
        $previousFetchedAt = $globalQuote->getFetchedAt();

        $this->globalQuoteService->execute($symbol);

        $globalQuote = $this->globalQuoteRepository->getBySymbolAndLatestTradingDay(
            $symbol,
            $latestTradingDay
        );

        assertNotNull($globalQuote);
        $newFetchedAt = $globalQuote->getFetchedAt();
        $this->assertTrue($newFetchedAt > $previousFetchedAt);
    }

    public function testLastTradingDayDoesNotExistInDB(): void
    {
        $this->saveData();

        $symbol = 'GOOG';

        $latestTradingDay = $this->finnHubClient->getLatestTradingDay();

        $globalQuote = $this->globalQuoteRepository->getBySymbolAndLatestTradingDay(
            $symbol,
            $latestTradingDay
        );

        assertNull($globalQuote);

        $this->globalQuoteService->execute($symbol);

        $globalQuote = $this->globalQuoteRepository->getBySymbolAndLatestTradingDay(
            $symbol,
            $latestTradingDay
        );

        assertNotNull($globalQuote);
    }

    private function saveData(): void
    {
        $json = file_get_contents(__DIR__.'/Fixtures/global_quotes_data.json');
        $data = json_decode($json, true);

        foreach ($data as $response) {
            $date = $response['Global Quote']['07. latest trading day'];
            $dateTime = new \DateTime($date);
            $dateTime->modify('-1 day');
            $dateNormalized = $dateTime->format('Y-m-d');
            $response['Global Quote']['07. latest trading day'] = $dateNormalized;
            $globalQuoteDTO = QuoteResponseMapper::fromApi($response);
            $globalQuoteEntity = GlobalQuoteEntityMapper::fromDto($globalQuoteDTO);
            $globalQuoteEntity->setFetchedAt(new \DateTime('yesterday'));
            $this->globalQuoteRepository->save($globalQuoteEntity);
        }
    }
}
