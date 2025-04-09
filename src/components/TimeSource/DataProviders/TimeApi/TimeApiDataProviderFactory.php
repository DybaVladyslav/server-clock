<?php

namespace VladyslavDyba\ServerClock\components\TimeSource\DataProviders\TimeApi;

use VladyslavDyba\ServerClock\contracts\IpSourceInterface;

/**
 * Factory for TimeApi service as a time data provider
 */
final class TimeApiDataProviderFactory
{
    private const BASE_URL = 'https://timeapi.io/api/';

    public static function make(IpSourceInterface $ipSource): TimeApiDataProvider
    {
        return new TimeApiDataProvider(new TimeApiClient(
            baseUri: self::BASE_URL,
            timeout: 10.0,
        ), $ipSource);
    }
}
