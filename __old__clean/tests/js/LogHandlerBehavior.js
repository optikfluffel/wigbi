$(document).ready(function()
{
	module("LogHandler");
	
	
	
	test("constructor_shouldInitObject", 2, function()
	{
		var obj = new LogHandler("foo bar");
		
		same(obj.className(), "LogHandler");
		same(obj.id(), "foo bar");
	});
	
	test("constructor_shouldHandleEmptyId", 1, function()
	{
		var obj = new LogHandler();
		
		same(obj.id(), "");
	});
	
	
	
	test("handlers_shouldReturnEmptyObjectByDefault", 1, function()
	{
		var obj = new LogHandler();
		
		same(obj.handlers(), []);
	});
	
	test("id_shouldGetAndSetValue", 3, function()
	{
		var obj = new LogHandler("foo bar");
		
		same(obj.id(), "foo bar");
		same(obj.id("foo"), "foo");
		same(obj.id(), "foo");
	});
	
	test("priorityNames_shouldContainCorrectValues", 8, function()
	{
		var obj = new LogHandler("foo bar");
		
		same(obj._priorityNames[0], "emergency");
		same(obj._priorityNames[1], "alert");
		same(obj._priorityNames[2], "critical");
		same(obj._priorityNames[3], "error");
		same(obj._priorityNames[4], "warning");
		same(obj._priorityNames[5], "notice");
		same(obj._priorityNames[6], "info");
		same(obj._priorityNames[7], "debug");
	});
	
	
	
	test("addHandler_shouldAddMultipleHandlers", 15, function()
	{
		var obj = new LogHandler();
		
		obj.addHandler([0,1,2,3,4,5,6,7], true, "foobar", true, "foobar", true, true);
		obj.addHandler([0,7], false, "foo bar", false, "foo, bar", false, false);
		
		same(obj.handlers().length, 2);
		
		same(obj.handlers()[0]["priorities"], [0,1,2,3,4,5,6,7]);
		same(obj.handlers()[0]["display"], true);
		same(obj.handlers()[0]["file"], "foobar");
		same(obj.handlers()[0]["firebug"], true);
		same(obj.handlers()[0]["mailaddresses"], "foobar");
		same(obj.handlers()[0]["syslog"], true);
		same(obj.handlers()[0]["window"], true);
		
		same(obj.handlers()[1]["priorities"], [0,7]);
		same(obj.handlers()[1]["display"], false);
		same(obj.handlers()[1]["file"], "foo bar");
		same(obj.handlers()[1]["firebug"], false);
		same(obj.handlers()[1]["mailaddresses"], "foo, bar");
		same(obj.handlers()[1]["syslog"], false);
		same(obj.handlers()[1]["window"], false);
	});
	
	test("getRequestObject_shouldAdjustFilePath", 7, function()
	{
		var obj = new LogHandler();
		
		obj.addHandler([1, 2], 1, "foo.txt", 2, "foo@bar.com,bar@foo.com", 3, 4);
		obj = obj.getRequestObject();
		
		same(obj.handlers()[0]["priorities"], [1, 2]);
		same(obj.handlers()[0]["display"], 1);
		same(obj.handlers()[0]["file"], "../../foo.txt");
		same(obj.handlers()[0]["firebug"], 2);
		same(obj.handlers()[0]["mailaddresses"], "foo@bar.com,bar@foo.com");
		same(obj.handlers()[0]["syslog"], 3);
		same(obj.handlers()[0]["window"], 4);
	});
	
	test("getRequestObject_shouldIgnoreEmptyFilePath", 7, function()
	{
		var obj = new LogHandler();
		
		obj.addHandler([1, 2], 1, "", 2, "foo@bar.com,bar@foo.com", 3, 4);
		obj = obj.getRequestObject();
		
		same(obj.handlers()[0]["priorities"], [1, 2]);
		same(obj.handlers()[0]["display"], 1);
		same(obj.handlers()[0]["file"], "");
		same(obj.handlers()[0]["firebug"], 2);
		same(obj.handlers()[0]["mailaddresses"], "foo@bar.com,bar@foo.com");
		same(obj.handlers()[0]["syslog"], 3);
		same(obj.handlers()[0]["window"], 4);
	});
	
	test("log_todo", 0, function()
	{
		//How to test logging in JavaScript?
	});
});