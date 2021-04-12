<?php
/**
 * SimpleView PHP Client Library
 *
 * PHP Version 7.1
 *
 * @category Library
 * @package  SimpleView
 * @author   Darren Odden <darren@odden.io>
 * @license  MIT ../LICENSE
 * @link     https://www.odden.io
 */

namespace SimpleView;

use nusoap_client;

/**
 * SimpleView PHP Library Class
 *
 * @category Library
 * @package  SimpleView
 * @author   Darren Odden <darren@odden.io>
 * @license  MIT ./LICENSE
 * @link     https://www.odden.io
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class SimpleViewLibrary
{
    private $_clientUserName = '';
    private $_clientPassword = '';
    private $_serviceUrl = '';
    private $_soapClient;

    /**
     * Construction site
     *
     * @param [type] $config configuration object
     */
    public function __construct($config)
    {
        $this->_clientUserName = $config->clientUserName;
        $this->_clientPassword = $config->clientPassword;
        $this->_serviceUrl = $config->serviceUrl;

        $client = new nusoap_client($this->_serviceUrl, 'wsdl');
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = false;
        $this->_soapClient = $client;
    }

    /**
     * Wrapper function to call soap client method.
     *
     * @param $action
     * @param array $params
     * @return bool|mixed
     */
    private function call($action, $params = [])
    {
        $data = array_merge([$this->_clientUserName, $this->_clientPassword], $params);

        try {
            $results = $this->_soapClient->call($action, $data);
        } catch (\Exception $e) {
            $results = false;
        }
        return $results;
    }

    /**
     * Get the listing types
     *
     * @param [bit] $showWeb a flag to get the listing types
     *
     * @return array|bool array response or false if failed.
     */
    public function getListingTypes($showWeb)
    {
        return $this->call('getListingTypes', [
            $showWeb
        ]);
    }

    /**
     * Get the business listings
     *
     * @param integer $pageNum the page requested
     * @param integer $pageSize the number of items per page
     * @param object $filter filtered listings
     * @param integer $displayAmenities amenities yes(1) or no(0)
     *
     * @return array|bool array response or false if failed.
     */
    public function getListings($pageNum, $pageSize, $filter, $displayAmenities = 0)
    {
        return $this->call('getListings', [
            $pageNum,
            $pageSize,
            $filter,
            $displayAmenities
        ]);
    }

    /**
     * Get the business listing
     *
     * @param integer $listingId the id number of the listing
     * @param integer $updateHits text
     *
     * @return array|bool array response or false if failed.
     */
    public function getListing($listingId, $updateHits = 0)
    {
        return $this->call('getListing', [
            $listingId,
            $updateHits
        ]);
    }

    /**
     * Get the listing categories
     *
     * @param [type] $listingTypeId use the listing type
     *
     * @return array|bool array response or false if failed.
     */
    public function getListingCategories($listingTypeId)
    {
        return $this->call('getListingCats', [
            $listingTypeId
        ]);
    }

    /**
     * Return listing subcategories
     *
     * @param [type] $listingCategoryId Category Id
     * @param [type] $listingTypeId     Type Id
     *
     * @return array|bool array response or false if failed.
     */
    public function getListingSubCategories($listingCategoryId, $listingTypeId)
    {
        return $this->call('getListingSubCats', [
            $listingCategoryId,
            $listingTypeId
        ]);
    }

    /**
     * List the regions
     *
     * @param [type] $catId Category Id
     *
     * @return array|bool array response or false if failed.
     */
    public function getListingRegions($catId)
    {
        return $this->call('getListingRegions', [
            $catId
        ]);
    }

    /**
     * List Amenities
     *
     * @return array|bool array response or false if failed.
     */
    public function getListingAmenities()
    {
        return $this->call('getAmenityList');
    }

    /**
     * Get amenity groups.
     *
     * @return array|bool array response or false if failed.
     */
    public function getAmenityGroups()
    {
        return $this->call('getAmenityGroups');
    }

    /**
     * Coupon categories
     *
     * @return array|bool array response or false if failed.
     */
    public function getCouponCategories()
    {
        return $this->call('getCouponCats');
    }

    /**
     * Coupons
     *
     * @param [type] $pageNum  page number
     * @param [type] $pageSize page size
     * @param [type] $filter   filter
     *
     * @return array|bool array response or false if failed.
     */
    public function getCoupons($pageNum, $pageSize, $filter)
    {
        return $this->call('getCoupons', [
            $pageNum,
            $pageSize,
            $filter
        ]);
    }

    /**
     * Coupons by category id
     *
     * @param integer $couponCatId category id
     * @param integer $pageNum page number
     * @param integer $pageSize number of results per page
     * @param object $filters filter
     *
     * @return array|bool array response or false if failed.
     */
    public function getCouponsByCategories(
        $couponCatId,
        $pageNum,
        $pageSize,
        $filters
    ) {
        return $this->call('getCouponsByCats', [
            $couponCatId,
            $pageNum,
            $pageSize,
            $filters
        ]);
    }

    /**
     * Coupons associated to the Listing Id
     *
     * @param [type] $listingId   Listing Id
     * @param [type] $pageNum     Page number
     * @param [type] $pageSize    results per page
     * @param [type] $redeemStart coupon redemption start date
     * @param [type] $redeemEnd   coupon redemption end date
     * @param [type] $keywords    keywords
     *
     * @return array|bool array response or false if failed.
     */
    public function getCouponsByListingId(
        $listingId,
        $pageNum,
        $pageSize,
        $redeemStart,
        $redeemEnd,
        $keywords
    ) {
        return $this->call('getCouponsByListingId', [
            $listingId,
            $pageNum,
            $pageSize,
            $redeemStart,
            $redeemEnd,
            $keywords
        ]);
    }

    /**
     * Get the coupon
     *
     * @param [type] $couponId   coupon id
     * @param [type] $updateHits how many times used
     *
     * @return array|bool array response or false if failed.
     */
    public function getCoupon($couponId, $updateHits)
    {
        return $this->call('getCoupon', [
            $couponId,
            $updateHits
        ]);
    }

    /**
     * Update the hits
     *
     * @param [type] $hitTypeID hit type id
     * @param [type] $recId     record id
     * @param [type] $hitDate   hit date
     *
     * @return void
     */
    public function updateHits($hitTypeID, $recId, $hitDate)
    {
        return $this->call('updatehits', [
            $hitTypeID,
            $recId,
            $hitDate
        ]);
    }

    /**
     * Get listing that has been added since $lastSync date.
     *
     * Note: this is a custom method which only available for some clients.
     *
     * @param string $lastSync
     *   Date string e.g. 2020-12-01
     *
     * @return array|bool array response or false if failed.
     */
    public function getNewListings($lastSync)
    {
        return $this->call('getNewListings', [$lastSync]);
    }

    /**
     * Get listing that has been updated since $lastSync date.
     *
     * Note: this is a custom method which only available for some clients.
     *
     * @param string $lastSync
     *   Date string e.g. 2020-12-01
     *
     * @return array|bool array response or false if failed.
     */
    public function getChangedListings($lastSync)
    {
        return $this->call('getChangedListings', [$lastSync]);
    }

    /**
     * Get listing that has been removed since $lastSync date.
     *
     * Note: this is a custom method which only available for some clients.
     *
     * @param string $lastSync
     *   Date string e.g. 2020-12-01
     *
     * @return array|bool array response or false if failed.
     */
    public function getRemovedListings($lastSync)
    {
        return $this->call('getRemovedListings', [$lastSync]);
    }
}
