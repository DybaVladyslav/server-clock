<?php

namespace VladyslavDyba\ServerClock\contracts;

use DateTimeImmutable;

/**
 * A source of time interface
 */
interface TimeSourceInterface
{
    public function getDateTime(): DateTimeImmutable;
}
