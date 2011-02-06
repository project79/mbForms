<link href="<?php echo URL_PUBLIC; ?>wolf/plugins/mbforms/css/style.css" media="screen" rel="Stylesheet" type="text/css" />
<div id="mbforms">
	<form method="post" action="<?php echo $formurl; ?>">
		<?php // don't remove this hidden field ?>
		<input type="hidden" name="formaction" value="send" />
		<?php // end ?>
	
		<?php echo (isset($errormsg)) ? '<div class="mberror">'.$errormsg.'</div>' : '';
			
			echo $formitems;
	
			if($form->usecaptcha == '1')
			{
				include_once(MBFORMS."/recaptchalib.php");
				echo '<div class="captcha">'.recaptcha_get_html($settings['publickey']).'</div>';
			}
		?>
		<div class="row">
			<label>&nbsp;</label>
			<input type="submit" name="form_submit" id="frm_submit" value="<?php echo __('Submit Form'); ?>" class="submit" />
		</div>
	</form>
</div>