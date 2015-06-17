<?php
namespace Subugoe\Addressmap\Domain\Repository;

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
use TYPO3\CMS\Core\Database\DatabaseConnection;

/**
 * Address repository
 */
class AddressRepository {

	/**
	 * @var DatabaseConnection
	 */
	protected $db;

	public function __construct() {
		$this->db = $GLOBALS['TYPO3_DB'];
	}

	/**
	 * @param int $category
	 * @return array
	 */
	public function queryDbByCategory($category) {
		$resultSet = [];
		$query = $this->db->exec_SELECT_mm_query(
				'*',
				'tt_address',
				'tt_address_group_mm',
				'tt_address_group',
				'AND NOT tt_address.deleted AND NOT tt_address.hidden AND uid_foreign = ' . (int) $category
		);

		while ($row = $this->db->sql_fetch_assoc($query)) {
			$resultSet[] = $row;
		}
		return $resultSet;
	}

	/**
	 * @param $address
	 * @return int
	 */
	public function updateAddress($address) {
		$this->db->exec_UPDATEquery('tt_address', 'uid = ' . intval($address['uid_local']), ['latitude' => $address['latitude'], 'longitude' => $address['longitude']]);
		return $this->db->sql_affected_rows();
	}

}
