<?php
/**
 * mbFormsItem
 * 
 * Form Builder Plugin for WolfCMS
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		/models/mbformsItem.php
 * @date		04/08/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

class mbformsItem extends Record
{
	const TABLE_NAME = 'mbforms_items';


	/**
	 * generateItem
	 *
	 * Generates the form item
	*/
	static public function generateItem($item, $prefill)
	{
		if(file_exists(MBFORMS.'/views/formitems/'.$item['type'].'.php') && !empty($item['type']))
		{
			return new View('../../plugins/mbforms/views/formitems/'.$item['type'], array('item' => $item, 'prefill' => $prefill));
		} else
		{
			return '';
		}
	}

}
