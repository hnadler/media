<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

// We only want to have file relations if extension File advanced metadata is loaded.
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('filemetadata')) {
	$configuration = '--div--;LLL:EXT:media/Resources/Private/Language/locallang_db.xlf:tab.relations, related_files';
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata',$configuration);
}

$tca = array(
	'ctrl' => array(
		'default_sortby' => 'ORDER BY uid DESC',
		'searchFields' => 'uid,extension,name', // sys_file_metadata.title,sys_file_metadata.keywords,
	),
	'columns' => array(
		'fileinfo' => array(
			'l10n_mode' => 'exclude',
			'config' => array(
				'type' => 'user',
				'userFunc' => 'EXT:media/Classes/Backend/TceForms.php:TYPO3\CMS\Media\Backend\TceForms->renderFileUpload',
			),
		),
		'related_files' => array(
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:media/Resources/Private/Language/locallang_db.xlf:sys_file_metadata.relations',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'related_files',
				array(),
				''
			),
		),
	),
);
\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($GLOBALS['TCA']['sys_file_metadata'], $tca);