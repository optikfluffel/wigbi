<?php

class ValidationHandlerBehavior extends UnitTestCase
{
	function ValidationHandlerBehavior()
	{
		$this->UnitTestCase("ValidationHandler");
	}

	
	
	function test_isEmail_shouldReturnFalseForInvalidStrings()
	{
		$this->assertFalse(ValidationHandler::isEmail("daniel.saidi@"));
		$this->assertFalse(ValidationHandler::isEmail("@gmail.com"));
		$this->assertFalse(ValidationHandler::isEmail("daniel.saidi@gmail"));
	}
	
	function test_isEmail_shouldReturnTrueForValidString()
	{
		$this->assertTrue(ValidationHandler::isEmail("daniel.saidi@gmail.com"));
	}
	
	function test_isHexColor_shouldReturnFalseForInvalidStrings()
	{
		$this->assertFalse(ValidationHandler::isHexColor("ffffff"));
		$this->assertFalse(ValidationHandler::isHexColor("#gggggg"));
		$this->assertFalse(ValidationHandler::isHexColor("#fffffff"));
		$this->assertFalse(ValidationHandler::isHexColor("#ff"));
	}
	
	function test_isHexColor_shouldReturnTrueForValidStrings()
	{
		$this->assertTrue(ValidationHandler::isHexColor("#fff"));
		$this->assertTrue(ValidationHandler::isHexColor("#ffffff"));
	}
	
	function test_isUrl_shouldReturnFalseForInvalidStrings()
	{
		$this->assertFalse(ValidationHandler::isUrl("htp://www.dn.se"));
		$this->assertFalse(ValidationHandler::isUrl("www.dn.se"));
		$this->assertFalse(ValidationHandler::isUrl("htp://www.dn.se."));
	}
	
	function test_isUrl_shouldReturnTrueForValidStrings()
	{
		$this->assertTrue(ValidationHandler::isUrl("ftp://www.dn.se"));
		$this->assertTrue(ValidationHandler::isUrl("http://www.dn.se"));
		$this->assertTrue(ValidationHandler::isUrl("https://www.dn.se"));
	}
	
	function test_urlExists_shouldReturnFalseForNonExistingUrl()
	{
		$this->assertFalse(ValidationHandler::urlExists("http://www.nonexistingurl.com"));
	}
	
	function test_urlExists_shouldReturnTrueForExistingUrl()
	{
		$this->assertTrue(ValidationHandler::urlExists("http://www.dn.se"));
	}
}

?>