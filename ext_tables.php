<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'vendor/autoload.php');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'map', 'Abonnentenkarte');

$pluginSignature = $_EXTKEY . '_map';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Addressmap.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Addressmap');

$coordinateColums = array(
	'latitude' => array(
		'exclude' => 1,
		'label' => 'Latitude',
		'config' => array('type' => 'input', 'size' => '40', 'eval' => 'trim')
	),
	'longitude' => array(
		'exclude' => 1,
		'label' => 'Longitude',
		'config' => array('type' => 'input', 'size' => '40', 'eval' => 'trim')
	),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address', $coordinateColums);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_address', 'latitude;;;;1-1-1', '', 'after:country');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_address', 'longitude;;;;1-1-1', '', 'after:latitude');

