<?php
/**
 * Run simpleview functionality
 *
 * PHP version 7.1
 *
 * @category    SimpleView_Soap
 * @package     SimpleView
 * @author      Darren Odden <darren@odden.io>
 * @file        simpleview.php
 * @copyright   2018 Darren Odden
 * @license     MIT /LICENSE
 * @version     GIT: @git_id@
 * @link        http://www.odden.io
 * @description main simpleView functionality
 */

require __DIR__ . '/vendor/autoload.php';

use SimpleView\SimpleViewLibrary;
use SimpleView\SimpleViewFilter;
use PHPUnit\Exception;

require_once __DIR__ . '/src/SimpleViewLibrary.php';
require_once __DIR__ . '/src/SimpleViewFilter.php';

/**
 * Create the soap connection
 *
 * @return object SimpleView SOAP connection
 */
function create()
{
    $config = getConfig();
    
    return new SimpleViewLibrary($config);
}

/**
 * Undocumented function
 *
 * @return object all listings filter
 */
function filterAll()
{
    $simpleViewFilter = new SimpleViewFilter(
        $config->filter->fieldCategory,
        $config->filter->fieldName,
        $config->filter->filterType,
        $config->filter->filterValue
    );

    $allListings = $simpleViewFilter->filterAllListings();

    return $allListings;
}

/**
 * Undocumented function
 *
 * @param object  $connection        SOAP Connection
 * @param array   $filterAllListings filter array for all listings
 * @param integer $pageSize          page size, maximum 100
 * @param integer $pageNumber        current page
 * @param bool    $showAmenities     show ammenities; true or false
 *
 * @return object Listings
 */
function getListings(
    $connection,
    $filterAllListings,
    $pageSize,
    $pageNumber,
    $showAmenities
) {
    return $connection->getListings(
        $pageNumber,
        $pageSize,
        $filterAllListings,
        $showAmenities
    );
}

/**
 * Get the number of results to process
 *
 * @param object $connection    SOAP connection
 * @param array  $filter        Array of filterAllListings
 * @param bool   $showAmenities True or False
 *
 * @return integer number of results
 */
function getResultsNumber(
    $connection,
    $filter,
    $showAmenities
) {
    $initial = $connection->getListings(
        1,
        1,
        $filter,
        $showAmenities
    );

    return $initial['STATUS']['RESULTS'];
}

/**
 * Get listing from SimpleView
 *
 * @param object  $connection SimpleView SOAP connection
 * @param integer $listId     Listing ID
 * @param integer $updateHits 0
 *
 * @return object listing
 */
function getListing(
    $connection,
    $listId,
    $updateHits
) {
    return $connection->getListing($listId, $updateHits);
}

/**
 * Undocumented function
 *
 * @param [type] $connection simpleview connection object
 * @param [type] $filter     filter object
 * @param [type] $pageSize   how many results per page to return
 *
 * @return void
 */
function getListingIds($connection, $filter, $pageSize)
{
    $resultNumber = getResultsNumber($connection, $filter, 0);

    $pages = $resultNumber % $pageSize;
    $results = array();

    for ($page = 1; $page<=$pages; $page++) {
        $listings = $connection->getListings($page, $pageSize, $filter, 0);
    
        foreach ($listings["DATA"] as $listing) {
            array_push($results, $listing["LISTINGID"]);
        }
    }
    return $results;
}

/**
 * Undocumented function
 *
 * @return object
 */
function getConfig()
{
    $jsonStr = file_get_contents(__DIR__ . "/config.json");
    return json_decode($jsonStr);
}

/**
 * Undocumented function
 *
 * @return void
 */
function processListings()
{
    $connection = create();
    $filter     = filterAll();

    $config = getConfig();
    $pageSize = $config->pageSize;

    $listingIds = getListingIds($connection, $filter, $pageSize);

    foreach ($listingIds as $listingId) {
        $listing = getListing($connection, $listingId, 0);
        //TODO publish $listing
        if (is_array($listing)) {
        }
    }
}

/**
 * Undocumented function
 *
 * @param array $amenities array of amenities
 *
 * @return void
 */
function amenities($amenities)
{
    foreach ($amenities as $amenity) {
        if (strlen($amenity["VALUE"]) > 0) {
            print $amenity["NAME"] . "\n-----\n" . $amenity["VALUE"] . "\n\n";
        }
    }
}

/////////////////////////////////
$config = getConfig();

$connect = create();
// print var_dump($connect);

$filter = filterAll();
// print var_dump($filter);

// $listings = $connect->getListings(1, 1, $filter, false);
// print var_dump($listings);

// $listingIds = getListingIds($connect, $filter, 100);
// print var_dump($listingIds);

$listing = getListing($connect, 401, 0);
// print_r($listing["DATA"]);
amenities($listing["DATA"]["AMENITIES"]);
print "\n";
