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

use PHPUnit\Exception;

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
    private $_serviceUrl     = '';
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
        $this->_serviceUrl     = $config->serviceUrl;
        $this->_soapClient     = new \SoapClient($this->_serviceUrl, array('exceptions' => 0));
    }

    /**
     * Get the listing types
     *
     * @param [bit] $showWeb a flag to get the listing types
     *
     * @return $results
     */
    public function getListingTypes($showWeb)
    {
        $results;

        try {
            $results = $this->_soapClient->getListingTypes(
                $this->_clientUserName,
                $this->_clientPassword,
                $showWeb
            );
        } catch (Exception $e) {
            $results = $e;
        }

        return $results;
    }

    /**
     * Get the business listings
     *
     * @param integer $pageSize         the number of items per page
     * @param integer $pageNum          the page requested
     * @param object  $filter           filtered listings
     * @param integer $displayAmenities amenities yes(1) or no(0)
     *
     * @return $results
     */
    public function getListings($pageSize, $pageNum, $filter, $displayAmenities)
    {
        $results = null;

        if ($displayAmenities === null) {
            $displayAmenities = false;
        }

        try {
            $results = $this->_soapClient->getListings(
                $this->_clientUserName,
                $this->_clientPassword,
                $pageNum,
                $pageSize,
                $filter,
                ($displayAmenities === true) ? 1 : 0
            );
        } catch (Exception $e) {
            $results = $e;
        }

        return $results;
    }

    /**
     * Get the business listing
     *
     * @param integer $listingId  the id number of the listing
     * @param integer $updateHits text
     *
     * @return object
     */
    public function getListing($listingId, $updateHits = 0)
    {
        $results;

        try {
            $results = $this->_soapClient->getListing(
                $this->_clientUserName,
                $this->_clientPassword,
                $listingId,
                $updateHits
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
    }

    /**
     * Get the listing categories
     *
     * @param [type] $listingTypeId use the listing type
     *
     * @return void
     */
    public function getListingCategories($listingTypeId)
    {
        $results;

        try {
            $results = $this->_soapClient->getListingCats(
                $this->_clientUserName,
                $this->_clientPassword,
                $listingTypeId
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
    }

    /**
     * Return listing subcategories
     *
     * @param [type] $listingCategoryId Category Id
     * @param [type] $listingTypeId     Type Id
     *
     * @return void
     */
    public function getListingSubCategories($listingCategoryId, $listingTypeId)
    {
        $results;

        try {
            $results = $this->_soapClient->getListingSubCats(
                $this->_clientUserName,
                $this->_clientPassword,
                $listingCategoryId,
                $listingTypeId
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
    }

    /**
     * List the regions
     *
     * @param [type] $catId Category Id
     *
     * @return regions
     */
    public function getListingRegions($catId)
    {
        $results;

        try {
            $results = $this->_soapClient->getListingRegions(
                $this->_clientUserName,
                $this->_clientPassword,
                $catId
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
    }

    /**
     * List Amenities
     *
     * @return amenities
     */
    public function getListingAmenities()
    {
        $results;

        try {
            $results = $this->_soapClient->getListingAmenities(
                $this->_clientUserName,
                $this->_clientPassword
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
    }

    /**
     * Coupon categories
     *
     * @return void
     */
    public function getCouponCategories()
    {
        $results;

        try {
            $results = $this->_soapClient->getCouponCats(
                $this->_clientUserName,
                $this->_clientPassword
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
    }

    /**
     * Coupons
     *
     * @param [type] $pageNum  page number
     * @param [type] $pageSize page size
     * @param [type] $filter   filter
     *
     * @return void
     */
    public function getCoupons($pageNum, $pageSize, $filter)
    {
        $results;

        try {
            $results = $this->_soapClient->getCoupons(
                $this->_clientUserName,
                $this->_clientPassword,
                $pageNum,
                $pageSize,
                $filter
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
    }

    /**
     * Coupons by category id
     *
     * @param integer $couponCatId category id
     * @param integer $pageNum     page number
     * @param integer $pageSize    number of results per page
     * @param object  $filters     filter
     *
     * @return void
     */
    public function getCouponsByCategories(
        $couponCatId,
        $pageNum,
        $pageSize,
        $filters
    ) {
        $results;

        try {
            $results = $this->_soapClient->getCouponsByCats(
                $this->_clientUserName,
                $this->_clientPassword,
                $couponCatId,
                $pageNum,
                $pageSize,
                $filters
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
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
     * @return void
     */
    public function getCouponsByListingId(
        $listingId,
        $pageNum,
        $pageSize,
        $redeemStart,
        $redeemEnd,
        $keywords
    ) {
        $results;

        try {
            $results = $this->_soapClient->getCouponsByListingId(
                $this->_clientUserName,
                $this->_clientPassword,
                $listingId,
                $pageNum,
                $pageSize,
                $redeemStart,
                $redeemEnd,
                $keywords
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
    }

    /**
     * Get the coupon
     *
     * @param [type] $couponId   coupon id
     * @param [type] $updateHits how many times used
     *
     * @return void
     */
    public function getCoupon($couponId, $updateHits)
    {
        $results;

        try {
            $results = $this->_soapClient->getCoupon(
                $this->_clientUserName,
                $this->_clientPassword,
                $couponId,
                $updateHits
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
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
        $results;

        try {
            $results = $this->_soapClient->updateHits(
                $this->_clientUserName,
                $this->_clientPassword,
                $hitTypeID,
                $recId,
                $hitDate
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
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
        try {
            $results = $this->_soapClient->getNewListings(
                $this->_clientUserName,
                $this->_clientPassword,
                $lastSync
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
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
        try {
            $results = $this->_soapClient->getChangedListings(
                $this->_clientUserName,
                $this->_clientPassword,
                $lastSync
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
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
        try {
            $results = $this->_soapClient->getRemovedListings(
                $this->_clientUserName,
                $this->_clientPassword,
                $lastSync
            );
        } catch (Exception $e) {
            $results = false;
        }

        return $results;
    }
}
