<?php

class WigbiDataPluginJavaScriptGeneratorBehavior extends UnitTestCase
{
	private $obj;
	
	

	function WigbiDataPluginJavaScriptGeneratorBehavior()
	{
		$this->UnitTestCase("WigbiDataPluginJavaScriptGenerator");
	}
	
	function setUp()
	{
		$this->obj = new WigbiDataPluginJavaScriptGeneratorTestClass();
	}
	
	function tearDown() { }
	
	

	function test_getClassCode_shouldResetObject()
	{
		$this->assertEqual($this->obj->_name, "foo__20");
		WigbiDataPluginJavaScriptGenerator::getJavaScript($this->obj);
		$this->assertEqual($this->obj->_name, "foo");
	}
	
	function test_getClassCode_shouldReturnValidData()
	{
		//Reset date/time objects to avoid time issues
		$this->obj->_date = "";
		$this->obj->_dateTime = "";
		$this->obj->_time = "";
		$this->obj->_timeStamp = "";
		
		//Assert that the generated code and the template code match
		$result = WigbiDataPluginJavaScriptGenerator::getJavaScript($this->obj);
		$expectedResult = file_get_contents(Wigbi::serverRoot() . "tests/resources/wigbiDataPlugin_expected.js");
		
		//Remove tabs and line breaks since files may contain various formats
		$result = str_replace(array("\n", "\r", "\t", " ", "\o", "\xOB"), '', $result);
		$expectedResult = str_replace(array("\n", "\r", "\t", " ", "\o", "\xOB"), '', $expectedResult);
		
		//Make sure the strings match
		$this->assertEqual($result, $expectedResult);
	}
}



class WigbiDataPluginJavaScriptGeneratorTestClass extends WigbiDataPlugin
{
	public $_name = "foo__20";
	public $_age = 20;
	public $_date = "__DATE";
	public $_dateTime = "__DATETIME";
	public $_time = "__TIME";
	public $_timeStamp = "__TIMESTAMP";
	public $_noValue = "__20";
	public $_noType = "foo";
	
	public function __construct()
	{
		$this->registerAjaxFunction("nonStaticFunc", array("foo", "bar"), false);
		$this->registerAjaxFunction("staticFunc", array("bar", "foo"), true);
	}
	
	private $_private = "foo__20";
	protected $_protected = "foo__20";
	public function getPrivate() { return $this->_private; }
	public function getProtected() { return $this->_protected; }
}

?>