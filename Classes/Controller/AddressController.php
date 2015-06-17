<?php
namespace Subugoe\Addressmap\Controller;

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
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Show maps
 */
class AddressController extends ActionController {

	/**
	 * @var \Subugoe\Addressmap\Domain\Repository\AddressRepository
	 * @inject
	 */
	protected $addressRepository;

	/**
	 * @var \Subugoe\Addressmap\Service\GeoCodingService
	 * @inject
	 */
	protected $geoCodingService;

	public function initializeAction() {
		$this->addAssetsToHead();
	}

	public function mapAction() {
		$groupId = (int) $this->settings['addressGroup'];
		$addresses = $this->addressRepository->queryDbByCategory($groupId);

		$addresses = $this->geoCodingService->encode($addresses);

		$this->view->assign('addresses', $addresses);
	}

	protected function addAssetsToHead() {
		/** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer */
		$pageRenderer = $GLOBALS['TSFE']->getPageRenderer();

		$pageRenderer->addCssFile(ExtensionManagementUtility::siteRelPath('addressmap') . 'Resources/Public/Css/leaflet.css');
		$pageRenderer->addCssFile(ExtensionManagementUtility::siteRelPath('addressmap') . 'Resources/Public/Css/MarkerCluster.css');
		$pageRenderer->addCssFile(ExtensionManagementUtility::siteRelPath('addressmap') . 'Resources/Public/Css/addressmap.css');
		$pageRenderer->addJsFooterFile(ExtensionManagementUtility::siteRelPath('addressmap') . 'Resources/Public/JavaScript/leaflet.js');
		$pageRenderer->addJsFooterFile(ExtensionManagementUtility::siteRelPath('addressmap') . 'Resources/Public/JavaScript/leaflet.markercluster.js');
		$pageRenderer->addJsFooterFile(ExtensionManagementUtility::siteRelPath('addressmap') . 'Resources/Public/JavaScript/addressmap.js');
	}

}
