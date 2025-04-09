<?php

namespace VladyslavDyba\ServerClock\contracts;

/**
 * A source of IP interface
 */
interface IpSourceInterface
{
    public function getIp(): string;
}
