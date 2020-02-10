<?php

declare(strict_types=1);

namespace DigipolisGent\Geopunt\Geolocation\Filter;

/**
 * Interface for a collection of filters.
 */
interface FiltersInterface
{
    /**
     * Get all filters as an array containing [filter name] => [filter value].
     *
     * @return array
     */
    public function filters(): array;
}
