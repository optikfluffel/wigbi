$(document).ready(function()
{
	module("WigbiClass");
	
	
	
	test("constructor_shouldInitObject", 1, function()
	{
		var obj = new WigbiClass();
		
		equals(obj.className(), "WigbiClass");
	});
	
	
	
	test("className_shouldReturnCorrectValue", 1, function()
	{	
		var obj = new WigbiClass();
		
		equals(obj.className(), "WigbiClass");
	});
});