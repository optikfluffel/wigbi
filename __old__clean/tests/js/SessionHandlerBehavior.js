$(document).ready(function()
{
	module("SessionHandler");



	test("constructor_shouldInitDefaultObject", 2, function()
	{
		var obj = new SessionHandler();
	
		equals(obj.className(), "SessionHandler");
		equals(obj.applicationName(), null);
	});
	
	test("constructor_shouldInitCustomObject", 2, function()
	{
		var obj = new SessionHandler("tmp");
	
		equals(obj.className(), "SessionHandler");
		equals(obj.applicationName(), "tmp");
	});
	
	
	
	test("applicationName_shouldGetSetValue", 3, function()
	{
		var obj = new SessionHandler("tmp");
		
		equals(obj.applicationName(), "tmp");
		equals(obj.applicationName("wigbi"), "wigbi");
		equals(obj.applicationName(), "wigbi");
	});
	
	
	
	asyncTest("test_clear_shouldClearSetData", 1, function()
	{
		var obj = new SessionHandler("tmp");
		
		obj.set("foo", "bar", function(result) {
			obj.clear("foo", function() {
				obj.get("foo", function(response) {
					equals(response, null);
					start();
				});
			});	
		});
	});
	
	asyncTest("test_get_shouldReturnNullForNonExistingData", 1, function()
	{
		var obj = new SessionHandler("tmp");
		
		obj.get("undefined", function(response) {
			equals(response, null);
			start(); 
		});
	});
	
	asyncTest("test_set_get_shouldSetAndReturnString", 1, function()
	{
		var obj = new SessionHandler("tmp");
		
		obj.set("foo", "bar", function() {
			obj.get("foo", function(response) {
				equals(response, "bar");
				start(); 
			});	
		});
	});
	
	asyncTest("test_set_get_shouldReturnNullForDifferentApplicationName", 1, function()
	{
		var obj = new SessionHandler("tmp");
		
		obj.set("foo", "bar", function() {
			obj.applicationName("tmp2");
			obj.get("foo", function(response) {
				equals(response, null);
				start(); 
			});	
		});
	});
	
	asyncTest("test_set_get_shouldSetAndReturnInteger", 1, function()
	{
		var obj = new SessionHandler("cache");
		
		obj.set("foo", 3, function() {
			obj.get("foo", function(response) {
				equals(response, 3);
				start(); 
			});	
		});
	});
	
	test("getRequestObject_shouldReturnAdjustedSessionHandlerInstance", 2, function()
	{
		var obj = new SessionHandler("tmp");
		
		equals(obj.applicationName("tmp"), "tmp");
		equals(obj.getRequestObject().applicationName(), "tmp");
	});
});