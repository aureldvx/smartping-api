<?php

namespace SmartpingApi\Service;

use SmartpingApi\Contract\UseCase\CommonInterface;
use SmartpingApi\Enum\ApiEndpoint;
use SmartpingApi\Model\Common\Initialization;
use SmartpingApi\Model\Common\News;

final class CommonAPI extends SmartpingCore implements CommonInterface
{
    /**
     * @inheritdoc
     */
    public static function authenticate() : bool
    {
        /** @var Initialization|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_INITIALISATION,
            requestParams: [],
            normalizationModel: Initialization::class,
            rootKey: 'initialisation'
        );

        return $response && $response->authorized();
    }

    /**
     * @inheritdoc
     */
    public static function getFederationNewsFeed() : array
    {
        /** @var News[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_NEW_ACTU,
            requestParams: [],
            normalizationModel: News::class,
            rootKey: 'news',
        );

        return $response ?? [];
    }
}
