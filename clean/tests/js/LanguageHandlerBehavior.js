$(document).ready(function() {

	module("LanguageHandler");
	
	
	
	test("constructor_shouldInitObject", 2, function()
	{
		var obj = new LanguageHandler({"foo":"bar"});
	
		equals(obj.className(), "LanguageHandler", "");
		same(obj.data(), {"foo":"bar"}, "");
	});

	
	
	test("translate_shouldReturnNonExistingParameterInSection", 2, function()
	{
		var obj = new LanguageHandler({"section1":{"foo1":"foo","bar1":"bar"},"section2":{"foo2":"bar","bar2":"foo"}});
		
		equals(obj.translate("foo2", "section1"), "foo2");
		equals(obj.translate("foo1", "section2"), "foo1");
	});
	
	test("translate_shouldTranslateExistingParameterInSection", 2, function()
	{
		var obj = new LanguageHandler({"section1":{"foo1":"foo","bar1":"bar"},"section2":{"foo2":"bar","bar2":"foo"}});
		
		equals(obj.translate("foo1", "section1"), "foo");
		equals(obj.translate("foo2", "section2"), "bar");
	});
	
	test("translate_shouldTranslateExistingHierarchicalParameterInSection", 3, function()
	{
		var obj = new LanguageHandler({"section1":{"foo":"foo","bar foo":"bar"}});
		
		equals(obj.translate("foo", "section1"), "foo");
		equals(obj.translate("bar foo", "section1"), "bar");
		equals(obj.translate("bad foo", "section1"), "foo");
	});
	
	test("translate_shouldReturnNonExistingParameterWithoutSection", 1, function()
	{
		var obj = new LanguageHandler({"foo":"bar"});
		
		equals(obj.translate("bar"), "bar");
	});
	
	test("translate_shouldTranslateExistingParameterWithoutSection", 1, function()
	{
		var obj = new LanguageHandler({"foo":"bar"});
		
		equals(obj.translate("foo"), "bar");
	});
	
	test("translate_shouldTranslateExistingHierarchicalParameterWithoutSection", 3, function()
	{
		var obj = new LanguageHandler({"foo":"foo","bar foo":"bar"});
		
		equals(obj.translate("foo"), "foo");
		equals(obj.translate("bar foo"), "bar");
		equals(obj.translate("bad foo"), "foo");
	});
});