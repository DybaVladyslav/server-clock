<?php

namespace VladyslavDyba\ServerClock\components\IpSource\DataProviders\IpInfo;

/**
 * Factory for IpInfo service as an IP data provider
 */
final class IpInfoDataProviderFactory
{
    private const BASE_URI = 'https://ipinfo.io/json';

    public static function make(): IpInfoDataProvider
    {
        return new IpInfoDataProvider(new IpInfoClient(
            baseUri: self::BASE_URI,
            timeout: 10.0,
        ));
    }
}
