<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

/**
 * Configure the Plugin to call the 
 * right combination of Controller and Action according to
 * the user input (default settings, FlexForm, URL etc.)
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Subugoe.' . $_EXTKEY, // The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	'national', // A unique name of the plugin in UpperCamelCase
	array(// An array holding the controller-action-combinations that are accessible
		'Address' => 'national',
	)
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Subugoe.' . $_EXTKEY, // The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	'international', // A unique name of the plugin in UpperCamelCase
	array(// An array holding the controller-action-combinations that are accessible
		'Address' => 'international' // The first controller and its first action will be the default
	)
);
