<div class="row">
	<label for="frm_<?php echo $item['id']; ?>" class="clear"><?php echo $item['label']; echo ($item['isrequired'] == '1') ? '*' : ''; ?></label>
	<?php
		$ex = explode(",", $item['formvalues']);
		foreach($ex as $k => $v)
		{
			$v =  htmlspecialchars($v);
			$sel = '';
			if(!empty($prefill) && $prefill == $v)
			{
				$sel = ' checked="checked"';
			}
			echo '<label for="'.$item['id'].'-'.$k.'">'.$v.'</label><input style="width: auto;" type="radio" name="form['.$item['id'].']"'.$item['extras'].' value="'.$v.'"'.$sel.' />';
		}
	?>
</div>