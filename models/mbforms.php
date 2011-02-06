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
 * @file		/models/mbforms.php
 * @date		25/07/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

class mbforms extends Record
{
	const TABLE_NAME = 'mbforms';
	
	static public $formvalues = null;


	static public function getForm($name, $returnData=false)
	{	
		// get the form and set the submit uyrl
		$form = self::findOneFrom('mbforms', "`formname` = ".$name);
		if(CURRENT_URI == '')
		{
			$formurl = URL_PUBLIC;
		} else
		{
			$formurl = URL_PUBLIC.CURRENT_URI.URL_SUFFIX;
		}
		$formitems = '';		
		
		// setup array to pass into view later
		$viewArray = array('form' => $form,
						   'formurl' => $formurl);
		
		// check for (and assign) any data for prefill to retain user submission in the event of an error)				   
		if(is_array(self::$formvalues))
		{	
			$viewArray['formvalues'] = array();
			foreach(self::$formvalues['formvalues'] as $k => $v)
			{
				$viewArray['formvalues'][$k] = $v;
			}
		}					   
		
		// get the form items
		$viewArray['items'] = (array)mbformsItem::findAllFrom('mbformsItem', '`formid` = '.Record::escape($form->id).'ORDER BY `orderno` ASC, `id` ASC');
		foreach($viewArray['items'] as $k => $v)
		{
			$arrayV = (array)$v;
			// check this item for a prefill
			$prefill = '';
			if(isset($viewArray['formvalues'][$arrayV['id']]))
			{
				$prefill = $viewArray['formvalues'][$arrayV['id']];
			}			
			$formitems .= mbformsItem::generateItem($arrayV, $prefill);
		}
		// set form items to view array and get / set the plugin settings
		$viewArray['formitems'] = $formitems;
		$viewArray['settings'] = Plugin::getAllSettings('mbforms');
		
		// finally check for any error messages and display these
		if(is_array(self::$formvalues['errors']))
		{
			$viewArray['errormsg'] = implode("<br />", self::$formvalues['errors']);		
		}
		
		// return the array or display
		if($returnData)
		{
			return $viewArray;
		} else
		{		
			return new View('../../plugins/mbforms/views/form', $viewArray);
		}
	}
	
	static public function setValues($array)
	{
		self::$formvalues = $array;
	}	
}
