<?php

declare(strict_types=1);

namespace unit\components\IpSource;

use PHPUnit\Framework\TestCase;
use VladyslavDyba\ServerClock\components\IpSource\ExternalIpSource;
use VladyslavDyba\ServerClock\contracts\IpSourceDataProviderInterface;

/**
 * @covers \VladyslavDyba\ServerClock\components\IpSource\ExternalIpSource
 */
class ExternalIpSourceTest extends TestCase
{
    /**
     * @covers \VladyslavDyba\ServerClock\components\IpSource\ExternalIpSource::getIp
     */
    public function testGetIp(): void
    {
        $ip = '127.0.0.1';

        $mock = $this->getMockBuilder(IpSourceDataProviderInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getIp'])
            ->getMock();
        $mock->method("getIp")->willReturn($ip);

        $ipSource = new ExternalIpSource($mock);
        $this->assertEquals($ip, $ipSource->getIp());
    }
}
