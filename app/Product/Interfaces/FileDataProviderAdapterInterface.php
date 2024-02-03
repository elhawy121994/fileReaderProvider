<?php

namespace App\Product\Interfaces;

interface FileDataProviderAdapterInterface
{
    public function readData(array $filters = []): array;
}
