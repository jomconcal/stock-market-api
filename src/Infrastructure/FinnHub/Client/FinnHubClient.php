<?php

declare(strict_types=1);

namespace App\Infrastructure\FinnHub\Client;

use App\Domain\FinnHub\Client\FinnHubClientInterface;
use App\Domain\FinnHub\Entity\FinnHubLog;
use App\Domain\FinnHub\Entity\QuoteEntity;
use App\Domain\FinnHub\Enum\FinnHubFunction;
use App\Domain\FinnHub\Enum\FinnHubProvider;
use App\Domain\FinnHub\Enum\FinnHubStatus;
use App\Domain\FinnHub\Exception\FinnHubConnectionException;
use App\Domain\FinnHub\Repository\FinnHubLogRepositoryInterface;
use App\Domain\FinnHub\VO\Ticker;
use App\Infrastructure\Parser\ValueParser;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class FinnHubClient implements FinnHubClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $apiKey,
        private FinnHubLogRepositoryInterface $logRepository,
    ) {
    }

    #[\Override]
    public function fetchQuote(Ticker $ticker): QuoteEntity
    {
        $data = $this->doQuoteRequest($ticker->getSymbol());

        $currentPrice = ValueParser::toFloat($data['c']);
        $change = ValueParser::toFloat($data['d']);
        $changePercent = ValueParser::toFloat($data['dp']);
        $high = ValueParser::toFloat($data['h']);
        $low = ValueParser::toFloat($data['l']);
        $open = ValueParser::toFloat($data['o']);
        $previousClose = ValueParser::toFloat($data['pc']);
        $timeStamp = ValueParser::toString($data['t']);
        $lastUpdate = \DateTimeImmutable::createFromFormat('U', $timeStamp);

        if (false === $lastUpdate) {
            throw new \RuntimeException('Invalid date format: '.$timeStamp);
        }

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

    /**
     * @return array<array-key, mixed>
     *
     * @throws FinnHubConnectionException
     */
    #[\Override]
    public function doQuoteRequest(string $symbol): array
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://finnhub.io/api/v1/quote',
                [
                    'query' => [
                        'symbol' => strtoupper($symbol),
                        'token' => $this->apiKey,
                    ],
                ]
            );

            $log = new FinnHubLog(
                status: FinnHubStatus::SUCCESS,
                symbol: $symbol,
                finnHubFunction: FinnHubFunction::QUOTE,
                provider: FinnHubProvider::FINN_HUB,
                response: $response->toArray(),
            );
            $this->logRepository->save($log);

            return $response->toArray();
        } catch (\Throwable $e) {
            $log = new FinnHubLog(
                status: FinnHubStatus::ERROR,
                symbol: $symbol,
                finnHubFunction: FinnHubFunction::QUOTE,
                provider: FinnHubProvider::FINN_HUB,
                response: [$e->getMessage()],
            );
            $this->logRepository->save($log);
            throw FinnHubConnectionException::create($e->getMessage(), (int) $e->getCode(), $e);
        }
    }
}
