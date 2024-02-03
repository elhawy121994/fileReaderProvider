<?php

namespace App\Product;

use App\Product\LookUps\DataProviderFactoryLookUps;
use App\Product\DataProviders\XFileDataProvider;
use App\Product\DataProviders\YFileDataProvider;
use App\Product\Interfaces\DataProviderFactoryInterface;

class ProviderFactory implements DataProviderFactoryInterface
{
    public static function getProviders(string $providerName = ''): array
    {
        switch ($providerName) {
            case DataProviderFactoryLookUps::X_DATA_PROVIDER :

                return [resolve(XFileDataProvider::class)];
            case DataProviderFactoryLookUps::Y_DATA_PROVIDER:

                return [resolve(YFileDataProvider::class)];
            default:
                return [resolve(YFileDataProvider::class), resolve(XFileDataProvider::class)];
        }
    }
}
