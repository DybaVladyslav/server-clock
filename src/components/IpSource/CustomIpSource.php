<?php

namespace VladyslavDyba\ServerClock\components\IpSource;

use VladyslavDyba\ServerClock\contracts\IpSourceInterface;

/**
 * Implements IpSourceInterface and is a custom IP source
 * IP can be set directly
 */
final class CustomIpSource implements IpSourceInterface
{
    public function __construct(
        private readonly string $ip
    ) {
    }

    public function getIp(): string
    {
        return $this->ip;
    }
}
