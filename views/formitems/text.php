<div class="row">
	<label for="frm_<?php echo $item['id']; ?>"><?php echo $item['label']; echo ($item['isrequired'] == '1') ? '*' : ''; ?></label>
	<textarea name="form[<?php echo $item['id']; ?>]" id="frm_<?php echo $item['id']; ?>"<?php echo $items['extras']; ?> cols="1" rows="1"><?php echo (!empty($prefill)) ? $prefill : ''; ?></textarea>
</div>