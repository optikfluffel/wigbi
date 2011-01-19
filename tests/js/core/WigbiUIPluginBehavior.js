$(document).ready(function()
{
	module("WigbiUIPlugin");
	
	
	
	test("constructor_shouldInitObject", 2, function()
	{
		var obj = new WigbiUIPlugin("foobar");
	
		equals(obj.className(), "WigbiUIPlugin");
		equals(obj.id(), "foobar");
	});
	
	
	
	test("id_shouldReturnCorrectValue", 1, function()
	{	
		var obj = new WigbiUIPlugin("foobar");
		
		equals(obj.id(), "foobar");
	});
	
	
	
	test("bindErrors_shouldSetTitle", 2, function()
	{
		var obj = new WigbiUIPlugin("test");
  	obj.bindErrors(["element1", "element2"], ["element1_required", "element2_invalid"]);	
		
		equals(obj.getElement("element1").title(), "element1_required");
		equals(obj.getElement("element2").title(), "element2_required");
	});
	
	test("bindErrors_shouldSetErrorClass", 2, function()
	{
		var obj = new WigbiUIPlugin("test");
  	obj.bindErrors(["element1", "element2"], ["element1_required", "element2_invalid"]);	
		
		ok(obj.getElement("element1").hasClass("invalid"));
		ok(obj.getElement("element2").hasClass("invalid"));
	});
	
	test("bindErrors_shouldResetTitle", 2, function()
	{
		var obj = new WigbiUIPlugin("test");
  	obj.bindErrors(["element1", "element2"], ["element1_required", "element2_invalid"]);
  	obj.bindErrors(["element1", "element2"], ["element1_required"]);	
		
		equals(obj.getElement("element1").title(), "element1_required");
		equals(obj.getElement("element2").title(), "");
	});
	
	test("bindErrors_shouldResetErrorClass", 2, function()
	{
		var obj = new WigbiUIPlugin("test");
  	obj.bindErrors(["element1", "element2"], ["element1_required", "element2_invalid"]);
  	obj.bindErrors(["element1", "element2"], ["element1_required"]);	
		
		ok(obj.getElement("element1").hasClass("invalid"));
		ok(!obj.getElement("element2").hasClass("invalid"));
	});
	
	test("bindErrors_shouldHandleCommaString", 4, function()
	{
		var obj = new WigbiUIPlugin("test");
  	obj.bindErrors(["element1", "element2"], "element1_required,element2_invalid");	
		
		equals(obj.getElement("element1").title(), "element1_required");
		equals(obj.getElement("element2").title(), "element2_required");	
		ok(obj.getElement("element1").hasClass("invalid"));
		ok(obj.getElement("element2").hasClass("invalid"));
	});
	
	test("getElement_shouldReturnElement", 1, function()
	{
		var obj = new WigbiUIPlugin("test");
		
		equals(obj.getElement("name").attr("title"), "foo bar");
	});
	
	test("getElementData_shouldReturnObject", 1, function()
	{
		var obj = new WigbiUIPlugin("test");
		
		equals(obj.getElementData("name", {}).name, "foo bar");
	});
	
	test("reset_shouldNotDoAnything", 1, function()
	{
		var obj = new WigbiUIPlugin("test");
		
		equals(obj.reset(), null);
	});
	
	test("submit_shouldNotDoAnything", 1, function()
	{
		var obj = new WigbiUIPlugin("test");
		
		equals(obj.submit(), null);
	});
	
	test("translate_shouldAppendPrefix", 1, function()
	{
		var obj = new WigbiUIPlugin("test");
		
		equals(obj.translate("foo"), "test WigbiUIPlugin foo");
	});
});