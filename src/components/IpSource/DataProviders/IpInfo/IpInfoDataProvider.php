<?php

namespace VladyslavDyba\ServerClock\components\IpSource\DataProviders\IpInfo;

use VladyslavDyba\ServerClock\components\IpSource\Exceptions\EmptyIpSourceException;
use VladyslavDyba\ServerClock\components\IpSource\Exceptions\WrongResponseException;
use VladyslavDyba\ServerClock\contracts\IpSourceDataProviderInterface;
use function var_export;

/**
 * IpInfo service as an IP data provider
 */
final class IpInfoDataProvider implements IpSourceDataProviderInterface
{
    public function __construct(
        private readonly IpInfoClient $client
    ) {
    }

    public function getIp(): string
    {
        $data = $this->client->getIp();
        if (!$data) {
            throw new EmptyIpSourceException('Empty IP source');
        }

        if (!$data['ip'] ?? null) {
            throw new WrongResponseException(sprintf(
                'Response does not contain a valid IP address: %s',
                var_export($data)
            ));
        }

        return $data['ip'];
    }
}
