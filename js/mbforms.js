/* mbForms Javascript / jQuery Functions */


/*
	addItem
	
	This appends a new form item to the end of the form.
*/
function addItem()
{
	var tpl = $("#itemTPL").html();
	var key = $("#indexCount").html();
	
	if(key == '')
	{
		key = 1;
	}
	tpl = tpl.replace(/key/gi, key);	
	$("#formItems").append(tpl);
	
	// setup the delete item buttons
	deleteItem();
	
	// increment key 
	key = (parseInt(key) + 1);
	$("#indexCount").html(key);
	return false;
}


/*
	deleteItem
	
	Delete the selected item
*/
function deleteItem()
{
	$(".deleteItem").click(function() {
		$(this).parents(".row").remove();
		return false;
	});
} 