<?php

namespace VladyslavDyba\ServerClock\components\TimeSource\DataProviders\TimeApi;

use GuzzleHttp\Client;
use JsonException;
use Throwable;
use VladyslavDyba\ServerClock\components\TimeSource\Exceptions\TimeSourceRequestException;
use function http_build_query;
use function json_decode;
use function sleep;
use function sprintf;

final class TimeApiClient
{
    private const DEFAULT_REQUEST_RETRIES_NUMBER = 3;

    private readonly Client $client;

    public function __construct(
        string $baseUri,
        float $timeout = 3.0,
        private readonly int $requestRetries = self::DEFAULT_REQUEST_RETRIES_NUMBER,
    )
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout'  => $timeout,
        ]);
    }

    /**
     * @param string $ip
     * @return array
     * @throws JsonException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrentTimeByIp(string $ip): array
    {
        $counter = 0;
        do {
            try {
                $queryParams = http_build_query(['ipAddress' => $ip]);
                $response = $this->client->get(sprintf('time/current/ip?%s', $queryParams));
                $responseBody = $response->getBody()->getContents();
                $json = json_decode($responseBody, true);

                if (null === $json) {
                    throw new JsonException(sprintf(
                        'Answer %s can not be decoded. Last error: %s',
                        $responseBody,
                        json_last_error_msg()
                    ));
                }

                return $json;
            } catch (Throwable $e) {
                if (++$counter > $this->requestRetries) {
                    throw new TimeSourceRequestException(
                        message: $e->getResponse()->getBody()->getContents(),
                        previous: $e,
                    );
                }
                sleep(1); // Cooling down
            }
        } while(true);
    }
}
