<?php
/**
 * mbForms
 * 
 * Form Builder Plugin for WolfCMS
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		uninstall.php
 * @date		16/08/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

$PDO = Record::getConnection();

// delete tbl
$table1 = "DROP TABLE `".TABLE_PREFIX."mbforms`;";
$PDO->exec($table1);

$table2 = "DROP TABLE `".TABLE_PREFIX."mbforms_items`;";
$PDO->exec($table2);

// delete settings
Plugin::deleteAllSettings('mbforms');