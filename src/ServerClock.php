<?php

namespace VladyslavDyba\ServerClock;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;
use VladyslavDyba\ServerClock\contracts\TimeSourceInterface;

/**
 * Implements PSR-20 ClockInterface
 * Provides time based on $timeSource implementation
 */
class ServerClock implements ClockInterface
{
    public function __construct(
        private readonly TimeSourceInterface $timeSource,
    ) {
    }

    public function now(): DateTimeImmutable
    {
        return $this->timeSource->getDateTime();
    }
}
