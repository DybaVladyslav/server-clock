<?php

namespace VladyslavDyba\ServerClock\contracts;

interface IpSourceDataProviderInterface
{
    public function getIp(): string;
}
