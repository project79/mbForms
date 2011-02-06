/* mbForms Javascript / jQuery Functions */


/*
	addItem
	
	This appends a new form item to the end of the form.
*/
function addItem()
{
	var tpl = $j("#itemTPL").html();
	var key = $j("#indexCount").html();
	
	if(key == '')
	{
		key = 1;
	}
	tpl = tpl.replace(/key/gi, key);	
	$j("#formItems").append(tpl);
	
	// setup the delete item buttons
	deleteItem();
	
	// increment key 
	key = (parseInt(key) + 1);
	$j("#indexCount").html(key);
	return false;
}


/*
	deleteItem
	
	Delete the selected item
*/
function deleteItem()
{
	$j(".deleteItem").click(function() {
		$j(this).parents(".row").remove();
		return false;
	});
} 