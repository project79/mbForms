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
 * @file		/views/admin/form.php
 * @date		26/07/2010
 * 
*/
// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}
?>
<h1><?php echo ($act == 'add') ? __('Create Form') : __('Edit Form'); ?></h1>
<br /><br />
<div id="mbforms">

	<?php echo (isset($errormsg)) ? '<div class="mberror">'.$errormsg.'</div>' : ''; ?>

	<form method="post" action="<?php echo ($act == 'add') ? get_url('plugin/mbforms/manage') : get_url('plugin/mbforms/manage/'.$form->id);  ?>">
		<div class="row">
			<label for="frm_title"><?php echo __('Form Name'); ?>*</label>
			<input type="text" name="form[formname]" id="frm_title" value="<?php echo (isset($form->formname)) ? $form->formname : ''; ?>" />
		</div>	
		
		<div class="row">
			<label for="frm_emailto"><?php echo __('Email Results To'); ?>*</label>
			<input type="text" name="form[emailto]" id="frm_emailto" value="<?php echo (isset($form->emailto)) ? $form->emailto : ''; ?>" />
		</div>
		
		<div class="row">
			<label for="frm_usecaptcha"><?php echo __('Use Captcha'); ?></label>
			<input class="checkbox" type="checkbox" name="form[usecaptcha]" id="frm_usecaptcha" value="1" <?php echo (isset($form->usecaptcha) && $form->usecaptcha == 1) ? 'checked="checked"'  : ''; ?> />
		</div>
	
		<div class="row">
			<label for="frm_successtpl"><?php echo __('Success Template'); ?>*</label>
			<select id="frm_successtpl" name="form[successtpl]">
				<option value=''><?php echo __('Select Template'); ?></option>
				<?php
					foreach($resultTpls as $v)
					{
				?>
				<option value="<?php echo $v; ?>"<?php echo (isset($form->successtpl) && $form->successtpl == $v) ? ' selected="selected"' : ''; ?>><?php echo $v; ?></option>
				<?php
					}
				?>			
			</select>			
		</div>
		<h2>
			<a href="#" class="add_item" onclick="return addItem();"><?php echo __('Add Item'); ?></a>
			<?php echo __('Items'); ?>**
		</h2>
		
		<div id="formItems">
		<?php
			$indexKey = 0;
			if(isset($items) && count($items) > 0)
			{
				foreach($items as $key => $item)
				{
					$indexKey = $key;
					foreach($item as $k => $v)
					{
						$item[$k] = htmlspecialchars($v);
					}
				
		?>		
			<div class="row item">
				<div class="delButton"><h2><a href="#" class="deleteItem"><?php echo __('Delete Item'); ?></a></h2></div>
				
				<div class="row_half">
					<label for="frm_label<?php echo $key; ?>"><?php echo __('Label'); ?></label>
					<input type="text" name="item[<?php echo $key; ?>][label]" id="frm_label<?php echo $key; ?>" value="<?php echo $item['label']; ?>" />
				</div>	
				<div class="row_half clear_row">
					<label for="frm_extras<?php echo $key; ?>"><?php echo __('Extras'); ?>***</label>
					<input type="text" name="item[<?php echo $key; ?>][extras]" id="frm_extras<?php echo $key; ?>" value="<?php echo $item['extras']; ?>" />
				</div>
				<div class="row_half">
					<label for="frm_orderno<?php echo $key; ?>"><?php echo __('Order'); ?></label>
					<input type="text" name="item[<?php echo $key; ?>][orderno]" id="frm_orderno<?php echo $key; ?>" value="<?php echo $item['orderno']; ?>" />
				</div>
				<div class="row_half clear_row">
					<label for="frm_type<?php echo $key; ?>"><?php echo __('Type'); ?></label>
					<select name="item[<?php echo $key; ?>][type]" id="frm_type<?php echo $key; ?>">
						<option value="input"<?php echo ($item['type'] == 'input') ? ' selected="selected"' : ''; ?>><?php echo __('Input Box'); ?></option>
						<option value="text"<?php echo ($item['type'] == 'text') ? ' selected="selected"' : ''; ?>><?php echo __('Text Area'); ?></option>
						<option value="select"<?php echo ($item['type'] == 'select') ? ' selected="selected"' : ''; ?>><?php echo __('Drop Down'); ?></option>
						<option value="checkbox"<?php echo ($item['type'] == 'checkbox') ? ' selected="selected"' : ''; ?>><?php echo __('Checkbox'); ?></option>
						<option value="radio"<?php echo ($item['type'] == 'radio') ? ' selected="selected"' : ''; ?>><?php echo __('Radio Buttons'); ?></option>				
					</select>
				</div>
				<div class="row_full">
					<label for="frm_required<?php echo $key; ?>"><?php echo __('Required?'); ?></label>
					<input class="checkbox" type="checkbox" name="item[<?php echo $key; ?>][isrequired]" id="frm_required<?php echo $key; ?>" value="1"<?php echo (isset($item['isrequired']) && $item['isrequired'] == '1') ? ' checked="checked"' : ''; ?> />
				</div>		
				<div class="row_full">
					<label for="frm_values<?php echo $key; ?>"><?php echo __('Values'); ?></label>
					<input type="text" name="item[<?php echo $key; ?>][formvalues]" id="frm_values<?php echo $key; ?>" value="<?php echo $item['formvalues']; ?>" class="clear_row" /><br />
					<p><?php echo __('For drop downs and radio buttons. Seperate the options with a comma.'); ?></p>
				</div>		
			</div>				
		<?php		
				}
			}
			$indexKey++;
		?>
		</div>

		<div class="row"> &nbsp; </div>
		<p class="buttons">	
			<input class="button submit"  type="submit" name="save" value="<?php echo __('Save Form'); ?>" />
		</p>
	</form>
	<div class="row_full no_padd">
		<p>* <?php echo __('Denotes required fields'); ?><br />
		** <?php echo __('You must add at least one form item.'); ?><br />
		*** <?php echo __("For class's, JS events etc..."); ?></p>
	</div>
</div>

<!-- HIDDEN DIVS! -->
<div id="indexCount" style="display: none;"><?php echo $indexKey; ?></div>
<div id="itemTPL">
	<div class="row item">
		<div class="delButton"><h2><a href="#" class="deleteItem"><?php echo __('Delete Item'); ?></a></h2></div>
		
		<div class="row_half">
			<label for="frm_labelKEY"><?php echo __('Label'); ?></label>
			<input type="text" name="item[KEY][label]" id="frm_labelKEY" value="" />
		</div>	
		<div class="row_half clear_row">
			<label for="frm_extrasKEY"><?php echo __('Extras'); ?>***</label>
			<input type="text" name="item[KEY][extras]" id="frm_extrasKEY" value="" />
		</div>
		<div class="row_half">
			<label for="frm_ordernoKEY"><?php echo __('Order'); ?></label>
			<input type="text" name="item[KEY][orderno]" id="frm_ordernoKEY" value="" />
		</div>
		<div class="row_half clear_row">
			<label for="frm_typeKEY"><?php echo __('Type'); ?></label>
			<select name="item[KEY][type]" id="frm_typeKEY">
				<option value="input"><?php echo __('Input Box'); ?></option>
				<option value="text"><?php echo __('Text Area'); ?></option>
				<option value="select"><?php echo __('Drop Down'); ?></option>
				<option value="checkbox"><?php echo __('Checkbox'); ?></option>
				<option value="radio"><?php echo __('Radio Buttons'); ?></option>				
			</select>
		</div>
		<div class="row_full">
			<label for="frm_requiredKEY"><?php echo __('Required?'); ?></label>
			<input class="checkbox" type="checkbox" id="frm_requiredKEY" name="item[KEY][isrequired]" value="1" />
		</div>		
		<div class="row_full">
			<label for="frm_valuesKEY"><?php echo __('Values'); ?></label>
			<input type="text" name="item[KEY][formvalues]" id="frm_valuesKEY" value="" class="clear_row" /><br />
			<p><?php echo __('For drop downs and radio buttons. Seperate the options with a comma.'); ?></p>
		</div>		
	</div>
</div>

