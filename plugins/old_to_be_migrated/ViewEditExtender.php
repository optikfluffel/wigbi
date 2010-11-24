//Setup the view/edit toggle behavior of the control
	initViewEditBehavior: function(viewControlId, editControlId, viewDivId, editDivId, viewButtonId, editButtonId)
	{
		$('#' + viewButtonId).click(function() {
			Wigbi.getControl(viewControlId).setObject(Wigbi.getControl(editControlId).object());
			$('#' + viewDivId).slideDown();
			$('#' + editDivId).slideUp();
			return false;
		});
			
		$('#' + editButtonId).click(function()
		{
			$('#' + editDivId).slideDown();
			$('#' + viewDivId).slideUp();
			return false;
		});
		
		if (!Wigbi.getControl(editControlId).object().id())
		{
			$('#' + editDivId).show();
			$('#' + viewDivId).hide();
		}
    },