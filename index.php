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
 * @file		index.php
 * @date		25/07/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

if(!defined("PLUGINS_ROOT")) // done to allow mbmenu to run on 0.6.0
{
	define('PLUGINS_ROOT', CORE_ROOT.'/plugins');
}
if(!defined("MBFORMS"))
{
	define('MBFORMS', PLUGINS_ROOT.'/mbforms');
}

// setup the plugin info
Plugin::setInfos(array(
    'id'          => 'mbforms',
    'title'       => 'mbForms', 
    'description' => 'Form Builder Plugin for WolfCMS', 
    'version'     => '1.0.3',
    'require_wolf_version' => '0.6',
    'type' => 'both',
    'author' 	  => 'Mike Barlow',
    'website'     => 'http://www.mikebarlow.co.uk',
	'update_url'  => 'http://www.mikebarlow.co.uk/mbplugins_version.xml'
	)
);
 
// Add the controller and tab for admin
Plugin::addController('mbforms', __('Form Builder'));

// Add the models to the autoLoader
AutoLoader::addFile('mbforms', MBFORMS.'/models/mbforms.php');
AutoLoader::addFile('mbformsItem', MBFORMS.'/models/mbformsItem.php');

if(defined("CMS_BACKEND"))
{
	// add the JS file
	Plugin::addJavascript('mbforms', 'js/mbforms.js');
} else
{
	// define form display function
	function mbForm($name)
	{
		$name = Record::escape($name);
		
		if(isset($_POST['formaction']) && $_POST['formaction'] == 'send')
		{
			$form = mbforms::getForm($name, true);
			$proceed = true;
			
			if($form['form']->usecaptcha == '1')
			{
				$proceed = false;
				include_once(MBFORMS."/recaptchalib.php");
				$resp = recaptcha_check_answer($form['settings']['privatekey'],
												$_SERVER["REMOTE_ADDR"],
												$_POST["recaptcha_challenge_field"],
												$_POST["recaptcha_response_field"]);
				if($resp->is_valid)
				{
					$proceed = true;				
				} else
				{
					$captcha_error = __('You did not enter the correct captcha code, please try again!');
				
				}
			}
			
			$required_errors = 0;
			// check for required fields
			foreach($form['items'] as $k => $item)
			{
				if($item->isrequired == '1')
				{
					if(!isset($_POST['form'][$item->id]) || empty($_POST['form'][$item->id]))
					{
						$required_errors++;
						$array['errors'][$item->id] = __("You have not filled out ")."'".$item->label."'";
					}				
				}
			}
			
			if($proceed === true && $required_errors === 0)
			{
				// let's email!
				// construct the body
				
				$email_body = __("There has been an email submission via :name. See below for submission details",array(':name'=>$name))."<br /><br />";
				
				foreach($form['items'] as $k => $item)
				{
					$email_body .= "<strong>".$item->label.":</strong> ".nl2br($_POST['form'][$item->id])."<br />";
				}	
			
				use_helper('Email');
				// setup email class
				$Email = new Email(array('mailtype' => 'html'));
				
				$Email->from(Setting::get('admin_email'), 'mbForms - '.$form['form']->formname);
				$Email->to($form['form']->emailto);
				$Email->subject($form['form']->formname.' '.__('Submission'));
				$Email->message($email_body);
				
				$send = $Email->send();
				
				if($send)
				{
					$tpl = explode('.', $form['form']->successtpl, 2);
					echo new View('../../plugins/mbforms/views/results/'.$tpl['0']);
				
				} else
				{
					$array['formvalues'] = $_POST['form'];
					$array['errors']['failed_to_send'] = __('Failed to send your email! Please try again');
					mbforms::setValues($array);
					echo mbforms::getForm($name);
				}			
			
			} else
			{
				$array['formvalues'] = $_POST['form'];
				if(isset($captcha_error))
				{
					$array['errors']['captcha_error'] = $captcha_error;
				}
				
				mbforms::setValues($array);
				echo mbforms::getForm($name);			
			}								
		} else
		{	
			echo mbforms::getForm($name);	
		}
	}
}
