<?php

require(__DIR__ . '/../vendor/autoload.php');

use VladyslavDyba\ServerClock\components\IpSource\CustomIpSource;
use VladyslavDyba\ServerClock\components\IpSource\DataProviders\IpInfo\IpInfoDataProviderFactory;
use VladyslavDyba\ServerClock\components\IpSource\ExternalIpSource;
use VladyslavDyba\ServerClock\components\TimeSource\DataProviders\TimeApi\TimeApiDataProviderFactory;
use VladyslavDyba\ServerClock\components\TimeSource\DefaultTimeSource;
use VladyslavDyba\ServerClock\ServerClock;

/**
 * This file provide opportunity to run basic implementation of the library and demonstrate how it works
 * Use CLI to perform the script:
 *      php [path to the package]/bin/console.php
 * To set a custom IP:
 *      php [path to the package]/bin/console.php 8.8.8.8
 */

// Define if IP has been provided
$ip = $argv[1] ?? null;

/**
 * Determine IpSource
 * Using CustomIpSource - if IP has been provided using parameter
 * Otherwise, the system tries to define its own external IP using ExternalIpSource
 */
$ipSource = $ip
    ? new CustomIpSource($ip)
    : new ExternalIpSource(IpInfoDataProviderFactory::make());

/**
 * Source of time
 * Current example works based on defined IP
 * Though, a client of the library can use its own implementation for TimeSourceDataProviderInterface
 */
$timeSource = new DefaultTimeSource(TimeApiDataProviderFactory::make($ipSource));

try {
    /**
     * ServerClock is the core of the library
     * It provides time based on TimeSourceInterface
     * As well, a client of the library can use its own implementation for TimeSourceInterface
     */
    $serverClock = new ServerClock($timeSource);
    $time = $serverClock->now();

    echo $time->format(DateTime::ATOM) . "\n";
} catch (Throwable $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
