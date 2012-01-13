$(document).ready(function()
{
	module("ValidationHandler");
	
	
	
	test("isEmail_shouldReturnFalseForInvalidStrings", 3, function()
	{
		ok(!ValidationHandler.isEmail("daniel.saidi@"));
		ok(!ValidationHandler.isEmail("@gmail.com"));
		ok(!ValidationHandler.isEmail("daniel.saidi@gmail"));
	});
	
	test("isEmail_shouldReturnTrueForValidString", 1, function()
	{
		ok(ValidationHandler.isEmail("daniel.saidi@gmail.com"));
	});
	
	test("isHexColor_shouldReturnFalseForInvalidStrings", 4, function()
	{
		ok(!ValidationHandler.isHexColor("ffffff"));
		ok(!ValidationHandler.isHexColor("#gggggg"));
		ok(!ValidationHandler.isHexColor("#fffffff"));
		ok(!ValidationHandler.isHexColor("#ff"));
	});
	
	test("isHexColor_shouldReturnTrueForValidStrings", 2, function()
	{
		ok(ValidationHandler.isHexColor("#fff"));
		ok(ValidationHandler.isHexColor("#ffffff"));
	});
	
	test("isUrl_shouldReturnFalseForInvalidStrings", 3, function()
	{
		ok(!ValidationHandler.isUrl("htp://www.dn.se"));
		ok(!ValidationHandler.isUrl("www.dn.se"));
		ok(!ValidationHandler.isUrl("htp://www.dn.se."));
	});
	
	test("isUrl_shouldReturnTrueForValidStrings", 3, function()
	{
		ok(ValidationHandler.isUrl("ftp://www.dn.se"));
		ok(ValidationHandler.isUrl("http://www.dn.se"));
		ok(ValidationHandler.isUrl("https://www.dn.se"));
	});
});