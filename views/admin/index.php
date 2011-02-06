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
 * @file		/views/admin/index.php
 * @date		25/07/2010
 * 
*/
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}
?>
<script type="text/javascript">
	function confirmAction()
	{
		var agree=confirm("<?php echo __('Are you sure?'); ?>");
	    if(agree)
	   	{
	        return true;
	    } else
	    {
	        return false;
	    }
	}
</script>
<h1><?php echo __('Forms'); ?></h1>
<br /><br />

<?php 
	if(!is_array($forms))
	{
		echo $forms;
	} else
	{
?>
<table width='100%' cellspacing='5' cellpadding='5' border='0'>
<tr>
	<td width='35%'><strong><?php echo __('Form Name'); ?></strong></td>
	<td width='7%' align="center"><strong><?php echo __('Edit'); ?></strong></td>
	<td width='10%' align="center"><strong><?php echo __('Delete'); ?></strong></td>
</tr>
<?php	
		$adminDel = get_url('plugin/mbforms/delete');
		$adminEdit = get_url('plugin/mbforms/manage');

		foreach($forms as $key => $post)
		{
?>
	<tr>
		<td><?php echo stripslashes($post->formname); ?></td>
		<td align="center"><a href="<?php echo $adminEdit."/".$post->id; ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbforms/images/paper_pencil_48.png" alt="Edit" width="20" /></a></td>
		<td align="center"><a href="<?php echo $adminDel."/".$post->id; ?>" onclick="return confirmAction();"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbforms/images/cancel_48.png" alt="Delete" width="20" /></a></td>
	</tr>
	<?php } ?>

</table>
<br />
<?php } ?>