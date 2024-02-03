<?php

namespace App\Product\DataProviders;

use App\Http\Resources\XDataProviderResource;
use App\Product\Interfaces\DataProviderInterface;
use App\Product\LookUps\DataProviderFiltersOperandLookUps;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
class XFileDataProvider extends FileDataProviderAdapter implements DataProviderInterface
{
    CONST STATUS_CODE_MAPPED_VALUE = [
        'authorised' => 1,
        'decline' => 2,
        'refunded' => 3,

    ];
    protected string $providerName = 'DataProviderX.json';
    public function parseFilters(array $filters = []) : ?array
    {
        $this->parseStatusCodeFilter($filters);
        $this->prepareBalanceFilter($filters);
        $this->prepareCurrencyFilter($filters);

        return $this->filters;
    }

    public function getData(array $filters = []): AnonymousResourceCollection
    {
        return XDataProviderResource::collection(parent::readData($this->parseFilters($filters)));
    }

    private function parseStatusCodeFilter($filters)
    {
        if (isset($filters['statusCode'])) {
            $this->filters[] = [
                'key' => 'statusCode',
                'values' => [static::STATUS_CODE_MAPPED_VALUE[$filters['statusCode']]],
                'operand' => DataProviderFiltersOperandLookUps::EQUAL,
            ];
        }
    }
    private function prepareBalanceFilter($filters)
    {
        if (isset($filters['balanceMin']) && isset($filters['balanceMax'])) {
            $this->filters[] = [
                'key' => 'parentAmount',
                'values' => [$filters['balanceMin'], $filters['balanceMax']],
                'operand' => DataProviderFiltersOperandLookUps::BETWEEN,
            ];
        } elseif (isset($filters['balanceMin'])) {
            $this->filters[] = [
                'key' => 'parentAmount',
                'values' => [static::STATUS_CODE_MAPPED_VALUE[$filters['balanceMin']]],
                'operand' => DataProviderFiltersOperandLookUps::GREATER_OR_EQUAL,
            ];
        } elseif (isset($filters['balanceMax'])) {
            $this->filters[] = [
                'key' => 'parentAmount',
                'values' => [$filters['balanceMax']],
                'operand' => DataProviderFiltersOperandLookUps::LESS_OR_EQUAL,
            ];
        }
    }
    private function prepareCurrencyFilter($filters)
    {
        if (isset($filters['currency'])) {
            $this->filters[] = [
                'key' => 'Currency',
                'values' => [$filters['currency']],
                'operand' => DataProviderFiltersOperandLookUps::EQUAL,
            ];
        }
    }
}
