<?php

declare(strict_types=1);

namespace unit\components\TimeSource;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use VladyslavDyba\ServerClock\components\TimeSource\DefaultTimeSource;
use VladyslavDyba\ServerClock\contracts\TimeSourceDataProviderInterface;

/**
 * @covers \VladyslavDyba\ServerClock\components\TimeSource\DefaultTimeSource
 */
class DefaultTimeSourceTest extends TestCase
{
    /**
     * @covers \VladyslavDyba\ServerClock\components\TimeSource\DefaultTimeSource::getDateTime
     */
    public function testGetDateTime(): void
    {
        $dateTime = new DateTimeImmutable();

        $mock = $this->getMockBuilder(TimeSourceDataProviderInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDate'])
            ->getMock();
        $mock->method("getDate")->willReturn($dateTime);

        $ipSource = new DefaultTimeSource($mock);
        $this->assertEquals($dateTime, $ipSource->getDateTime());
    }
}
