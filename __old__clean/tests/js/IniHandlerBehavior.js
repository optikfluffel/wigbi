$(document).ready(function() {

	module("IniHandler");
	
	
	
	test("constructor_shouldInitObject", 2, function()
	{
		var obj = new IniHandler({"foo":"bar"});
		
		equals(obj.className(), "IniHandler");
		same(obj.data(), {"foo":"bar"}); 
	});
	
	

	test("data_shouldGetSetValue", 3, function()
	{
		var obj = new IniHandler({"foo":"bar"});
		
		same(obj.data(), {"foo":"bar"});
		same(obj.data({"foobar":"foo bar"}), {"foobar":"foo bar"});
		same(obj.data(), {"foobar":"foo bar"});
	});
	
	test("data_shouldReturnEmptyArrayByDefault", 1, function()
	{
		var obj = new IniHandler();
		
		same(obj.data(), []);
	});

	
	
	test("get_shouldReturnNullForNonExistingParameterInSection", 2, function()
	{
		var obj = new IniHandler({"section1":{"foo1":"foo","bar1":"bar"},"section2":{"foo2":"bar","bar2":"foo"}});
		
		equals(obj.get("foo2", "section1"), null);
		equals(obj.get("foo1", "section2"), null);
	});
	
	test("get_shouldReturnExistingParameterInSection", 2, function()
	{
		var obj = new IniHandler({"section1":{"foo1":"foo","bar1":"bar"},"section2":{"foo2":"bar","bar2":"foo"}});
		
		equals(obj.get("foo1", "section1"), "foo");
		equals(obj.get("foo2", "section2"), "bar");
	});
	
	test("get_shouldReturnNullForNonExistingParameterWithoutSection", 1, function()
	{
		var obj = new IniHandler({"foo":"bar"});
		
		equals(obj.get("bar"), null);
	});
	
	test("get_shouldReturnExistingParameterWithoutSection", 1, function()
	{
		var obj = new IniHandler({"foo":"bar"});
		
		equals(obj.get("foo"), "bar");
	});
});