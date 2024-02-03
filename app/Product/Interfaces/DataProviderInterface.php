<?php

namespace App\Product\Interfaces;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface DataProviderInterface
{
    public function getData(array $filters = []): AnonymousResourceCollection;
    public function parseFilters(array $filters = []) : ?array;
}
