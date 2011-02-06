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
 * @file		/views/admin/sidebar.php
 * @date		25/07/2010
 * 
*/
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

echo "<p class='button'><a href='".get_url('plugin/mbforms/')."'><img src='".URL_PUBLIC."wolf/plugins/mbforms/images/navigate_48.png' align='middle' alt='mbForms Main Page Icon' />".__('Form List')."</a></p>
<p class='button'><a href='".get_url('plugin/mbforms/manage')."'><img src='".URL_PUBLIC."wolf/plugins/mbforms/images/add_48.png' align='middle' alt='Create Forms Icon' />".__('Create Form')."</a></p>
<p class='button'><a href='".get_url('plugin/mbforms/settings')."'><img src='".URL_PUBLIC."wolf/plugins/mbforms/images/spanner_48.png' align='middle' alt='mbForms Settings Icon' />".__('Form Settings')."</a></p>

<div class='box'>
	<h2>".__('Displaying Your Forms')."</h2>
	<p>".__("To display your form, place the follow code into the page you wish the form to appear on while substituting FORMNAME for the name of the your form.<br /><br />
	&lt;?php mbForm('FORMNAME'); ?&gt;")."</p>
</div>

<div class='box'>
	<h2>".__('mbForms Support')."</h2>
	".__('<p>For support visit <a href="http://www.mikebarlow.co.uk">www.mikebarlow.co.uk</a>.<br />
	This was a hobby project so support isn\'t full time but I will endeavour to answer questions and update the script as much as possible!<br /><br />
	
	Feedback / Suggestions are more then welcome.</p>')."
</div>";
