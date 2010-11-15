$(document).ready(function()
{
	module("Wigbi");


	
	test("asyncPostBackPage_shouldReturnCorrectValue", 1, function()
	{
		equals(Wigbi.asyncPostBackPage(), "wigbi/postBack.php");
	});
	
	test("cacheHandler_shouldReturnCorrectDefaultValue", 2, function()
	{
		equals(Wigbi.cacheHandler().className(), "CacheHandler");
		equals(Wigbi.cacheHandler().cacheFolder(), "cache");
	});
	
	test("dataPluginClasses_shouldReturnCorrectDefaultValue", 3, function()
	{
		var plugins = Wigbi.dataPluginClasses();
		
		equals(typeof(plugins), "object");
		equals(plugins.length, 1);
		equals(plugins[0], "Rating");
	});
	
	test("languageHandler_shouldReturnCorrectDefaultValue", 3, function()
	{
		equals(Wigbi.languageHandler().className(), "LanguageHandler");
		equals(Wigbi.languageHandler().data()["language"], "en");
		equals(Wigbi.languageHandler().data()["languageName"], "English");
	});
	
	test("logHandler_shouldReturnCorrectDefaultValue", 16, function()
	{
		equals(Wigbi.logHandler().className(), "LogHandler");
		equals(Wigbi.logHandler().handlers().length, 2);
		
		same(Wigbi.logHandler().handlers()[0]["priorities"], ["0","1","2","3","4","5","6","7"]);
		equals(Wigbi.logHandler().handlers()[0]["display"], "");
		equals(Wigbi.logHandler().handlers()[0]["file"], "log/event.log");
		equals(Wigbi.logHandler().handlers()[0]["firebug"], "");
		equals(Wigbi.logHandler().handlers()[0]["mailaddresses"], "");
		equals(Wigbi.logHandler().handlers()[0]["syslog"], "");
		equals(Wigbi.logHandler().handlers()[0]["window"], "");
		
		same(Wigbi.logHandler().handlers()[1]["priorities"], ["7"]);
		equals(Wigbi.logHandler().handlers()[1]["display"], 1);
		equals(Wigbi.logHandler().handlers()[1]["file"], "log/event.log");
		equals(Wigbi.logHandler().handlers()[1]["firebug"], 1);
		equals(Wigbi.logHandler().handlers()[1]["mailaddresses"], "daniel.saidi@gmail.com");
		equals(Wigbi.logHandler().handlers()[1]["syslog"], 1);
		equals(Wigbi.logHandler().handlers()[1]["window"], 1);
	});
	
	test("sessionHandler_shouldReturnCorrectDefaultValue", 2, function()
	{
		equals(Wigbi.sessionHandler().className(), "SessionHandler");
		equals(Wigbi.sessionHandler().applicationName(), "Wigbi Unit Tests");
	});
	
	test("uiPluginClasses_shouldReturnCorrectDefaultValue", 3, function()
	{
		var plugins = Wigbi.uiPluginClasses();
		
		equals(typeof(plugins), "object");
		equals(plugins.length, 1);
		equals(plugins[0], "LoginForm");
	});
	
	test("webRoot_shouldReturnCorrectDefaultValue", 1, function()
	{
  		equals(Wigbi.webRoot(), "");
	});
	
	
	
	asyncTest("ajax_shouldHandleParameter", 2, function()
	{
		Wigbi.ajax("Wigbi", null, "ping", ["foo"], function(result, exception) {
			equals(result, "foo");
			equals(exception, null);
			start();
		});
	});
	
	asyncTest("ajax_shouldHandleException", 2, function()
	{
		Wigbi.ajax("Wigbi", null, "ping", ["foo", true], function(result, exception) {
			equals(result, null);			
			equals(exception, "ERROR!");
			start();
		});
	});
});