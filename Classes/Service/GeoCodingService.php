<?php
namespace Subugoe\Addressmap\Service;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>
 *      Goettingen State Library
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use Geocoder\Exception\NoResult;
use Geocoder\Provider\GoogleMaps;
use Geocoder\Provider\LocaleAwareProvider;
use Ivory\HttpAdapter\CurlHttpAdapter;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service for geo coding
 */
class GeoCodingService {

	/**
	 * @var LocaleAwareProvider
	 */
	protected $geocoder;

	public function __construct() {
		$curl = new CurlHttpAdapter();
		$this->geocoder = new GoogleMaps($curl);
	}

	/**
	 * @param array $addresses
	 * @return array
	 */
	public function encode($addresses) {

		$geocodedAddresses = [];

		foreach ($addresses as $address) {
			if ($address['longitude'] && $address['latitude']) {
				$geocodedAddresses[] = $address;
			} else {
				$geocodedAddresses[] = $this->geocodeSingleAddress($address);
				sleep(2);
			}
		}

		return $geocodedAddresses;
	}

	/**
	 * @param $address
	 * @return array
	 */
	protected function geocodeSingleAddress($address) {
		$addressToQuery = $this->compileAddress($address);
		try {
			$result = $this->geocoder->geocode($addressToQuery);
			if ($result->count() > 0) {
				$address['latitude'] = $result->first()->getLatitude();
				$address['longitude'] = $result->first()->getLongitude();
				$this->persistEntry($address);
			}
		} catch (NoResult $e) {

		}
		return $address;
	}

	/**
	 * @param array $address
	 * @return string
	 */
	protected function compileAddress($address) {

		$values = [
			$address['last_name'],
			$address['address'],
			$address['zip'],
			$address['city'],
			$address['country']

		];
		array_map('trim', $values);
		$values = array_filter($values);
		return implode(', ', $values);
	}

	/**
	 * @param array $address
	 */
	protected function persistEntry($address) {
		/** @var \Subugoe\Addressmap\Domain\Repository\AddressRepository $repository */
		$repository = GeneralUtility::makeInstance(\Subugoe\Addressmap\Domain\Repository\AddressRepository::class);
		$repository->updateAddress($address);
	}

}
