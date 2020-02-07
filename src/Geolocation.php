<?php

declare(strict_types=1);

namespace DigipolisGent\Geopunt\Geolocation;

use DigipolisGent\API\Service\ServiceAbstract;
use DigipolisGent\Geopunt\Geolocation\Filter\Filters;
use DigipolisGent\Geopunt\Geolocation\Filter\NumberOfItemsFilter;
use DigipolisGent\Geopunt\Geolocation\Filter\SearchStringFilter;
use DigipolisGent\Geopunt\Geolocation\Request\LocationRequest;
use DigipolisGent\Geopunt\Geolocation\Request\SuggestionRequest;
use DigipolisGent\Geopunt\Geolocation\Value\Locations;
use DigipolisGent\Geopunt\Geolocation\Value\Suggestions;
use Webmozart\Assert\Assert;

/**
 * API wrapper to access the geolocation service methods.
 */
final class Geolocation extends ServiceAbstract implements GeolocationInterface
{
    /**
     * @inheritDoc
     */
    public function suggestions(string $search, int $limit): Suggestions
    {
        $this->limitIsWithinBoundaries($limit, 25);

        $filters = new Filters(
            new SearchStringFilter($search),
            new NumberOfItemsFilter($limit)
        );
        $request = new SuggestionRequest($filters);

        return $this->client()->send($request)->suggestions();
    }

    /**
     * @inheritDoc
     */
    public function locationsBySearch(string $search, int $limit): Locations
    {
        $this->limitIsWithinBoundaries($limit, 5);

        $filters = new Filters(
            new SearchStringFilter($search),
            new NumberOfItemsFilter($limit)
        );
        $request = new LocationRequest($filters);

        return $this->client()->send($request)->locations();
    }

    /**
     * Helper to check the limit value.
     *
     * @param int $limit
     *   The limit value to check.
     * @param int $max
     *   The maximum boundary (inclusive).
     *
     * @throws \InvalidArgumentException
     */
    private function limitIsWithinBoundaries(int $limit, int $max): void
    {
        Assert::greaterThan($limit, 0);
        Assert::lessThanEq($limit, $max);
    }
}
