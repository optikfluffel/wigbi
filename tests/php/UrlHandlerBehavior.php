<?php

class UrlHandlerBehavior extends UnitTestCase
{
	function UrlHandlerBehavior()
	{
    	$this->UnitTestCase("UrlHandler");
	}
	
	
	
	function test_currentPort_shouldReturnCorrectValue()
	{
		$this->assertEqual(UrlHandler::currentPort(), "8888");
	}
	
	function test_currentPort_shouldReturnBlankForPort80ByDefault()
	{
		$port = $_SERVER["SERVER_PORT"];
		$_SERVER["SERVER_PORT"] = "80";
		
		$this->assertEqual(UrlHandler::currentPort(), "");
		
		$_SERVER["SERVER_PORT"] = $port;
	}
	
	function test_currentPort_shouldReturnPort80IfRequested()
	{
		$port = $_SERVER["SERVER_PORT"];
		$_SERVER["SERVER_PORT"] = "80";
		
		$this->assertEqual(UrlHandler::currentPort(false), "80");
		
		$_SERVER["SERVER_PORT"] = $port;
	}
	
	function test_currentProtocol_shouldReturnCorrectValue()
	{
		$this->assertEqual(UrlHandler::currentProtocol(), "http");
	}
	
	function test_currentUrl_shouldReturnCorrectValue()
	{
		$this->assertEqual(UrlHandler::currentUrl(), "http://localhost:8888/wigbi_1/test.php");
	}
	
	
	
	function test_parseServerUrl_shouldParseUrlWithTilde()
	{
		$url = "~/tests";
		$this->assertEqual(UrlHandler::parseServerUrl($url), "tests");
	}
	
	function test_parseServerUrl_shouldParseUrlWithoutTilde()
	{
		$url = "http://www.saidi.se";
		$this->assertEqual(UrlHandler::parseServerUrl($url), $url);
	}
	
	function test_parseWebUrl_shouldParseUrlWithTilde()
	{
		$url = "~/tests";
		$this->assertEqual(UrlHandler::parseWebUrl($url), "tests");
	}
	
	function test_parseWebUrl_shouldParseUrlWithoutTilde()
	{
		$url = "http://www.saidi.se";
		$this->assertEqual(UrlHandler::parseWebUrl($url), $url);
	}
}

?>