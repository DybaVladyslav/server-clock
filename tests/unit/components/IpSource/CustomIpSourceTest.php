<?php

declare(strict_types=1);

namespace unit\components\IpSource;

use PHPUnit\Framework\TestCase;
use VladyslavDyba\ServerClock\components\IpSource\CustomIpSource;

/**
 * @covers \VladyslavDyba\ServerClock\components\IpSource\CustomIpSource
 */
class CustomIpSourceTest extends TestCase
{
    /**
     * @covers \VladyslavDyba\ServerClock\components\IpSource\CustomIpSource::getIp
     */
    public function testGetIp(): void
    {
        $ip = '8.8.8.8';
        $ipSource = new CustomIpSource($ip);
        $this->assertEquals($ip, $ipSource->getIp());
    }
}
