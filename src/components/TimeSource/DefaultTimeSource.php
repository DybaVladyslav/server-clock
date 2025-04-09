<?php

namespace VladyslavDyba\ServerClock\components\TimeSource;

use DateTimeImmutable;
use VladyslavDyba\ServerClock\contracts\TimeSourceDataProviderInterface;
use VladyslavDyba\ServerClock\contracts\TimeSourceInterface;

/**
 * Implements TimeSourceInterface and is a source of current time
 * Pay attention that current example uses a contract for the $dataProvider
 * to provide ability for Barbara Liskov substitution principle
 * but a client can avoid using data provider contract
 */
class DefaultTimeSource implements TimeSourceInterface
{
    public function __construct(
        private readonly TimeSourceDataProviderInterface $dataProvider,
    ) {
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->dataProvider->getDate();
    }
}
