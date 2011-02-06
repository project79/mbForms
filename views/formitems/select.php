<div class="row">
	<label for="frm_<?php echo $item['id']; ?>"><?php echo $item['label']; echo ($item['isrequired'] == '1') ? '*' : ''; ?></label>
	<select name="form[<?php echo $item['id']; ?>]" id="frm_<?php echo $item['id']; ?>"<?php echo $items['extras']; ?>>
		<option value=""><?php echo __('Please Select an Option'); ?></option>
		<?php
			$ex = explode(",", $item['formvalues']);
			foreach($ex as $v)
			{
				$v =  htmlspecialchars($v);
				$sel = '';
				if(!empty($prefill) && $prefill == $v)
				{
					$sel = ' selected="selected"';
				}				
				echo '<option value="'.$v.'"'.$sel.'>'.$v.'</option>';
			}
		?>
	</select>
</div>	