<?php

namespace VladyslavDyba\ServerClock\components\IpSource\DataProviders\IpInfo;

use GuzzleHttp\Client;
use JsonException;
use Throwable;
use VladyslavDyba\ServerClock\components\IpSource\Exceptions\IpSourceRequestException;
use function json_decode;
use function sleep;

final class IpInfoClient
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

    public function getIp(): array
    {
        $counter = 0;
        do {
            try {
                $response = $this->client->get('');
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
                    throw new IpSourceRequestException(
                        message: $e->getResponse()->getBody()->getContents(),
                        previous: $e,
                    );
                }
                sleep(1); // Cooling down
            }
        } while(true);
    }
}
