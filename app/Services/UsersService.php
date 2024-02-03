<?php

namespace App\Services;

use App\Product\ProviderFactory;
use App\Services\Interfaces\UsersServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class UsersService implements UsersServiceInterface
{
    public function __construct()
    {
    }

    public function list($options = [])
    {
        $collections = [];
        $result = collect([]);
        $providers = ProviderFactory::getProviders($options['provider'] ?? '');
        foreach ($providers as $provider) {
            $collection = $provider->getData($options);
            if ($collection) {
                $collections[] = $collection;
            }
        }
        if (count($collections) <= 1) {
            return $collections[0]->collection;
        }

        for ($i = 0; ($i < count($collections) - 1); $i++) {
            $result = $collections[$i]->merge($collections[$i + 1]);
        }

        return $result;
    }
}
