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
 * @file		MbformsController.php
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

class MbformsController extends PluginController 
{
	public $id;
	public $result = 'list';
	public $mbvars = array();

	// constructor function to setup class
    public function __construct() 
    {       
    	if(defined("CMS_BACKEND"))
    	{
    		AuthUser::load();
	        if ( ! AuthUser::isLoggedIn()) {
	            redirect(get_url('login'));
	        }
        	$this->setLayout('backend');
        	$this->assignToLayout('sidebar', new View('../../plugins/mbforms/views/admin/sidebar'));        	
		}
    }

	/**
     * index
     *
     * main admin menu page.
    */    
    public function index()
    {
    	if(defined("CMS_BACKEND"))
    	{
    		AuthUser::load();
	        if ( ! AuthUser::isLoggedIn()) {
	            redirect(get_url('login'));
	        }
	        
	        $forms = mbforms::findAllFrom('mbforms');
	        if(count($forms) === 0)
	        {
	        	$forms = "You have not yet created any forms";
	        }        	        
	        
	        $this->display('mbforms/views/admin/index', array('forms' => $forms));
    
    	} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
    }


   /**
    * manage
    *
    * add /edit forms
    */
   public function manage($id='')
   {
    	if(defined("CMS_BACKEND"))
    	{
    		$viewArray = array('resultTpls' => $this->getTpls());
    		$viewArray['act'] = (empty($id)) ? 'add' : 'edit';    		
    	
    		// check for form submission and then required fields
			if(isset($_POST['save']) && $_POST['save'] == __('Save Form'))
			{
				$message = $this->checkRequiredFields();
				
				if(empty($message))
				{
					// a ok....process!
					$flashError = $this->saveForm($viewArray['act'], $id);					
				} else
				{
					// didn't fill out all required fields
					$viewArray['errormsg'] = $message;
					$flashError = __('There were one or more errors with the data you entered!');					
				}				
				// flash error?
				if($this->checkEmpty($flashError))
				{
					Flash::setNow('error', $flashError);
				}				
			} 
			
			// assign form enteries back to tpl to prefill form
			if(isset($_POST['form']))
			{
				$viewArray['form'] = (object)$_POST['form'];
			} elseif(!empty($id))
			{
				$viewArray['form'] = (object)mbforms::findByIdFrom('mbforms', $id);
			}
			
			// add items if there are some
			if(isset($_POST['item']))	
			{
				$viewArray['items'] = $_POST['item'];
			} elseif(!empty($id))
			{	
				$viewArray['items'] = (array)mbformsItem::findAllFrom('mbformsItem', '`formid` = '.Record::escape($id).'ORDER BY `orderno` ASC, `id` ASC');
				foreach($viewArray['items'] as $k => $v)
				{
					$viewArray['items'][$k] = (array)$v;
				}
			}			
			
			// Let's form!
			$this->display('mbforms/views/admin/form', $viewArray);
						
		} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
    }

	/**
	 * delete
	 *
	 * Delete a form and all it's items
	*/
	public function delete($id)
	{
    	if(defined("CMS_BACKEND"))
    	{
			$result = mbforms::deleteWhere("mbforms", "`id` = ".Record::escape($id));			
			if($result === true)
			{	
				mbformsItem::deleteWhere("mbformsItem", "`formid` = ".Record::escape($id));
				Flash::setNow('success', __('Form has been deleted!'));
			} else
			{
				Flash::setNow('error', __('Failed to delete the form!'));
			}
			$this->index();
		} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
	}

    /**
     * documentation
     *
     * Documentation function to load the docs for the admin area
    */    
    public function documentation()
    {
    	if(defined("CMS_BACKEND"))
    	{
    		AuthUser::load();
	        if ( ! AuthUser::isLoggedIn()) {
	            redirect(get_url('login'));
	        }
	        $this->display('mbforms/views/admin/docs');
    
    	} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
    }
    
    
    /**
     * settings
     *
     * Function to manage the settings within mbforms
    */
    public function settings()
    {
    	if(defined("CMS_BACKEND"))
    	{
    		AuthUser::load();
	        if ( ! AuthUser::isLoggedIn()) {
	            redirect(get_url('login'));
	        }
	        
	        if(isset($_POST['save']) && $_POST['save'] == __('Save Settings'))
	        {
				Plugin::setAllSettings($_POST['setting'], 'mbforms');
				Flash::setNow('success', __('Settings have been saved!'));	       	
	        }
	        	        
	        $this->display('mbforms/views/admin/settings', array('settings' => Plugin::getAllSettings('mbforms')));
    	} else
    	{
            Flash::set('error', __('You do not have permission to access the requested page!'));
            redirect(get_url());
    	}
    } 
    
 
    /**
     * saveForm
     *
     * Do the form saving
    */
    protected function saveForm($type, $id='')
    {
    
    	$_POST['form']['usecaptcha'] = (isset($_POST['form']['usecaptcha']) ? '1' : '0');
    	if($type == 'add')
    	{
			$result = mbforms::insert("mbforms", $_POST['form']);
		} else
		{
			$result = mbforms::update("mbforms", $_POST['form'], "`id` = ".Record::escape($id));	
		}
		
		if($result === true)
		{
			// process and then check form items
			$formid = ($type == 'add') ? mbforms::lastInsertId() : $id;
			$success = 0;
			$fail = 0;
			
	    	if($type == 'edit')
	    	{
				$itemDelete = mbformsItem::deleteWhere("mbformsItem", "`formid` = ".Record::escape($formid));
			}			
			
			ksort($_POST['item']);
			foreach($_POST['item'] as $key => $item)
			{
				$item['formid'] = $formid;
				$item['isrequired'] = (isset($item['isrequired']) ? '1' : '0');
				$itemResult = mbformsItem::insert("mbformsItem", $item);
						
				if($itemResult === true)
				{
					$success++;
				} else
				{
					$fail++;
				}
			}
			
			// show success popup then show main listing
			if($success == count($_POST['item']))
			{
				Flash::setNow('success', __('Form has been saved!'));
	
			} elseif($success > 0 && $fail > 0)
			{
				Flash::setNow('success', __('Form has been saved, however not all the form items have been saved.'));
	
			} elseif($fail > 0)
			{
				Flash::setNow('success', __('Form has been saved, however <span style="text-decoration: underline">none</span> of the form fields have been saved.'));
			}
			$this->index();
			
		} else
		{
			$flashError = __("Failed to save your form, please try again.");
		}
		return $flashError;
    }
    
	/**
	 * checkEmpty
	 *
	 * Check field isn't empty
	*/	 
	protected function checkEmpty($field)
	{
		if(isset($field) && !empty($field))
		{
			return true;
		}
		return false;
	} 
        
    /**
     * checkRequiredFields
     *
     * Check for the required form fields
    */
    protected function checkRequiredFields()
    {
		$message = '';
	
		// check for required fields
		if(!$this->checkEmpty($_POST['form']['formname']))
		{
			$message .= __('You must fill out a name for this form').'<br />';
		}
		if(!$this->checkEmpty($_POST['form']['emailto']))
		{
			$message .= __('You must fill out a recipient email address for the form.').'<br />';
		}
		if(!$this->checkEmpty($_POST['form']['successtpl']))
		{
			$message .= __('You must select a success template.').'<br />';
		}
		if(!isset($_POST['item']) || !is_array($_POST['item']) || count($_POST['item']) == 0)
		{
			$message .= __('You must select at least one item for the form.').'<br />';
		}
    	 
        return $message;
	}
        
    /**
     * getTpls
     *
     * Retrieves an array of all the 'result' views
    */
    protected function getTpls()
    {
    	$scandir = scandir(MBFORMS.'/views/results/');
    	
    	foreach($scandir as $k => $v)
    	{
    		if($v == '.' || $v == '..' || $v == 'index.html')
    		{
    			unset($scandir[$k]);
    		}
    	}
    	return $scandir;    
    }
}
    