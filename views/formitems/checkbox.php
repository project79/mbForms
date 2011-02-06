<div class="row">
	<label for="frm_<?php echo $item['id']; ?>"><?php echo $item['label']; echo ($item['isrequired'] == '1') ? '*' : ''; ?></label>
	<?php
		$sel = '';
		if(!empty($prefill) && $prefill == '1')
		{
			$sel = ' checked="checked"';
		}
	?>	
	<input style="width: auto;" type="checkbox" name="form[<?php echo $item['id']; ?>]" id="frm_<?php echo $item['id']; ?>"<?php echo $item['extras']; ?> value="1"<?php echo $sel; ?> />
</div>	