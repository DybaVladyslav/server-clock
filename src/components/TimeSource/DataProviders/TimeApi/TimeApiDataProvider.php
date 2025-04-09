<?php

namespace VladyslavDyba\ServerClock\components\TimeSource\DataProviders\TimeApi;

use DateTimeImmutable;
use VladyslavDyba\ServerClock\components\TimeSource\Exceptions\EmptyTimeSourceException;
use VladyslavDyba\ServerClock\components\TimeSource\Exceptions\WrongResponseException;
use VladyslavDyba\ServerClock\contracts\IpSourceInterface;
use VladyslavDyba\ServerClock\contracts\TimeSourceDataProviderInterface;
use function var_export;

/**
 * TimeApi service as a time data provider
 */
final class TimeApiDataProvider implements TimeSourceDataProviderInterface
{
    public function __construct(
        private readonly TimeApiClient $client,
        private readonly IpSourceInterface $ipSource
    ) {
    }

    public function getDate(): DateTimeImmutable
    {
        $data = $this->client->getCurrentTimeByIp($this->ipSource->getIp());
        if (!$data) {
            throw new EmptyTimeSourceException('Empty time source');
        }

        if (!$data['dateTime'] ?? null) {
            throw new WrongResponseException(sprintf(
                'Response does not contain a valid Datetime: %s',
                var_export($data)
            ));
        }

        return new DateTimeImmutable($data['dateTime']);
    }
}
