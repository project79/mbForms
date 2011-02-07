<div class="row">
	<label for="frm_<?php echo $item['id']; ?>"><?php echo $item['label']; echo ($item['isrequired'] == '1') ? '*' : ''; ?></label>
	<input type="text" name="form[<?php echo $item['id']; ?>]" id="frm_<?php echo $item['id']; ?>"<?php echo $item['extras']; ?> value="<?php echo (!empty($prefill)) ? $prefill : ''; ?>" />
</div>	