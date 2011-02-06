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
 * @file		/views/admin/settings.php
 * @date		25/07/2010
 * 
*/
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}
?>

<h1><?php echo __('Form Settings'); ?></h1>
<br /><br />
<div id='mbforms'>

	<?php echo (isset($errorDesc)) ? $errorDesc : ''; ?>

	<form method='post' action='<?php echo get_url('plugin/mbforms/settings'); ?>'>
		<div class="row">
			<label for="frm_publickey" style="width: 170px;"><?php echo __('reCaptcha Public Key'); ?></label>
			<input type="text" name="setting[publickey]" size="40" id="frm_publickey" value="<?php echo $settings['publickey']; ?>" />
		</div>
		<div class="row">
			<label for="frm_privatekey" style="width: 170px;"><?php echo __('reCaptcha Private Key'); ?></label>
			<input type="text" name="setting[privatekey]" size="40" id="frm_privatekey" value="<?php echo $settings['privatekey']; ?>" />
		</div>
		<p class="buttons">	
			<input class="button submit"  type="submit" name="save" value="<?php echo __('Save Settings'); ?>" />
		</p>
		<div class="row"> &nbsp; </div>
		<?php echo __("You'll need to enter the correct keys in these fields to be able to use mbForms captcha functionality. mbForms uses reCaptcha for it's captcha functionality, you can create your keys <a href='https://www.google.com/recaptcha/admin/create'>here</a>"); ?>
	</form>
</div>
