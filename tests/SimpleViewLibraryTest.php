<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use SimpleView\SimpleViewLibrary;

class SimpleViewLibraryTest extends TestCase
{

    /**
     * Simpleview test config.
     *
     * @var object
     */
    private $config;

    /**
     * Simpleview library client.
     *
     * @var SimpleViewLibrary
     */
    private $simpleviewClient;

    /**
     * Setup config and simpleview client for testing.
     */
    protected function setUp()
    {
        $this->config = json_decode(file_get_contents(__DIR__ . "/../config-test.json"));
        $this->simpleviewClient = new SimpleViewLibrary($this->config);
    }

    /**
     * Test getListingTypes API method.
     *
     * @return void
     */
    public function testGetListingTypes()
    {
        $listingTypes = $this->simpleviewClient->getListingTypes(1);
        $this->assertIsArray($listingTypes['STATUS']);
        $this->assertArrayHasKey('HASERRORS', $listingTypes['STATUS']);
        $this->assertNotTrue($listingTypes['STATUS']['HASERRORS']);
    }

    /**
     * Test getChangedListings API method.
     *
     * @return void
     */
    public function testGetChangedListings()
    {
        $last_sync = date('Y-m-d', strtotime('last week'));
        $listings = $this->simpleviewClient->getChangedListings($last_sync);
        $this->assertIsArray($listings['STATUS']);
        $this->assertArrayHasKey('HASERRORS', $listings['STATUS']);
        $this->assertNotTrue($listings['STATUS']['HASERRORS']);
    }

    /**
     * Test getRemovedListings API method.
     *
     * @return void
     */
    public function testGetRemovedListings()
    {
        $last_sync = date('Y-m-d', strtotime('last week'));
        $listings = $this->simpleviewClient->getRemovedListings($last_sync);
        $this->assertIsArray($listings['STATUS']);
        $this->assertArrayHasKey('HASERRORS', $listings['STATUS']);
        $this->assertNotTrue($listings['STATUS']['HASERRORS']);
    }

    /**
     * Test updateHits API method.
     *
     * @return void
     */
    public function testUpdateHits()
    {
        $this->assertNotEmpty($this->config->testListingId);
        // The updateHits return empty string on success.
        $response = $this->simpleviewClient->updateHits(1, $this->config->testListingId, date('Y-m-d'));
        $this->assertIsString($response);
        $this->assertEquals('', $response);
    }
}
