<?php

namespace App\Product\Interfaces;

interface DataProviderFactoryInterface
{
    public static function getProviders(string $providerName = '') : array;
}
