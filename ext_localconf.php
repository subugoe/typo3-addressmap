<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY). 'vendor/autoload.php');

/**
 * Configure the Plugin to call the
 * right combination of Controller and Action according to
 * the user input (default settings, FlexForm, URL etc.)
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Subugoe.' . $_EXTKEY, // The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	'map', // A unique name of the plugin in UpperCamelCase
	array(// An array holding the controller-action-combinations that are accessible
		'Address' => 'map',
	)
);
