$(document).ready(function()
{
	module("CacheHandler");
	
	
	
	test("constructor_shouldInitDefaultObject", 2, function()
	{
		var obj = new CacheHandler();
	
		equals(obj.className(), "CacheHandler");
		equals(obj.cacheFolder(), null);
	});
	
	test("constructor_shouldInitCustomObject", 2, function()
	{
		var obj = new CacheHandler("tmp");
	
		equals(obj.className(), "CacheHandler");
		equals(obj.cacheFolder(), "tmp");
	});
	
	

	test("cacheFolder_shouldGetSetValue", 3, function()
	{
		var obj = new CacheHandler("tmp");
		
		equals(obj.cacheFolder(), "tmp");
		equals(obj.cacheFolder("cache"), "cache");
		equals(obj.cacheFolder(), "cache");
	});
	
	
	
	asyncTest("test_clear_shouldClearSetData", 2, function()
	{
		var obj = new CacheHandler("cache");
		
		obj.set("foo", "bar", 10, function(result) {
			obj.clear("foo", function(result) {
				ok(result);
				obj.get("foo", function(response) {
					equals(response, null);
					start();
				});
			});	
		});
	});
	
	asyncTest("test_get_shouldReturnNullForNonExistingData", 1, function()
	{
		var obj = new CacheHandler("cache");
		
		obj.get("undefined", function(response) {
			equals(response, null);
			start(); 
		});
	});
	
	asyncTest("test_set_get_shouldSetAndReturnString", 2, function()
	{
		var obj = new CacheHandler("cache");
		
		obj.set("foo", "bar", 10, function(result) {
			ok(result);
			obj.get("foo", function(response) {
				equals(response, "bar");
				start(); 
			});	
		});
	});
	
	asyncTest("test_set_get_shouldSetAndReturnInteger", 2, function()
	{
		var obj = new CacheHandler("cache");
		
		obj.set("foo", 3, 10, function(result) {
			ok(result);
			obj.get("foo", function(response) {
				equals(response, 3);
				start(); 
			});	
		});
	});

	test("getRequestObject_shouldReturnAdjustedCacheHandlerInstance", 2, function()
	{
		var obj = new CacheHandler("wigbi_1/cache");
		
		equals(obj.cacheFolder("wigbi_1/cache"), "wigbi_1/cache");
		equals(obj.getRequestObject().cacheFolder(), "../../wigbi_1/cache");
	});
});