<?php

namespace VladyslavDyba\ServerClock\components\IpSource;

use VladyslavDyba\ServerClock\contracts\IpSourceDataProviderInterface;
use VladyslavDyba\ServerClock\contracts\IpSourceInterface;

/**
 * Implements IpSourceInterface and is a source of current external server IP
 * Pay attention that current example uses a contract for the $dataProvider
 * to provide ability for Barbara Liskov substitution principle
 * but a client can avoid using data provider contract
 */
final class ExternalIpSource implements IpSourceInterface
{
    public function __construct(
        private readonly IpSourceDataProviderInterface $dataProvider
    ) {
    }

    public function getIp(): string
    {
        return $this->dataProvider->getIp();
    }
}
