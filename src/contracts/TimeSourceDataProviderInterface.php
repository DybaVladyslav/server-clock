<?php

namespace VladyslavDyba\ServerClock\contracts;

use DateTimeImmutable;

interface TimeSourceDataProviderInterface
{
    public function getDate(): DateTimeImmutable;
}
