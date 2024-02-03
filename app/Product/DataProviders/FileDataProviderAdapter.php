<?php

namespace App\Product\DataProviders;

use App\Helpers\JsonStreamReader;
use App\Product\Interfaces\FileDataProviderAdapterInterface;

class FileDataProviderAdapter implements FileDataProviderAdapterInterface
{
    protected array $filters = [];
    protected string $providerName;
    protected JsonStreamReader $jsonStreamReader;

    public function __construct()
    {
        $this->setJsonStreamReader();
    }

    protected function buildPath(): string
    {
        return public_path($this->providerName);
    }

    protected function setJsonStreamReader()
    {
        $this->jsonStreamReader = new JsonStreamReader($this->buildPath());
    }

    protected function closeStreamReader()
    {
        $this->jsonStreamReader->close();
    }

    public function readData(array $filters = []): array
    {
        $data = [];
        foreach ($this->jsonStreamReader->get() as $object) {
            if ($this->isMatched($object, $filters)) {
                $data[] = $object;
            }
        }

        $this->closeStreamReader();

        return $data;
    }

    protected function isMatched($product , $filters): bool
    {
        if (!empty($filters)) {
            foreach ($filters as  $filter) {
                //method name
                $methodName = $filter['operand'];
                $isMatched = $this->{$methodName}($product->{$filter['key']}, $filter['values']);
                if (!$isMatched) {
                    return false;
                }
            }
        }
        return true;
    }

    function equal($item, array $filter): bool
    {
        return $item === $filter[0];
    }

    function lessThan($item, array $filter): bool
    {
        return $item <= $filter[0];
    }

    function greaterThan($item, array $filter): bool
    {
        return $item >= $filter[0];
    }
    function between($item, array $filter): bool
    {
        return ($item <= $filter[0] && $item >= $filter[1]);
    }
}
