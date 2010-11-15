<?php

class WigbiUIPluginBehavior extends UnitTestCase
{	
	private $obj;
	private $id = "obj";
	
	
	
	function WigbiUIPluginBehavior()
	{
		$this->UnitTestCase("WigbiUIPlugin");
	}
	
	function setUp()
	{
		$this->obj = new MyUIPlugin($this->id);
	}
	
	function tearDown() { }
	
	
	
	function test_id_shouldBeSetByConstructor()
	{
		$this->assertEqual($this->obj->id(), $this->id);
	}
	
	
	
	function test_beginEditDiv_shouldAddElements()
	{
		ob_start();
		$this->obj->beginEditDiv();
		$result = ob_get_clean();
		
		$this->assertEqual(strpos($result, "<div id=\"" . $this->obj->id() . "-editPanel\" class=\"editPanel\">"), 0);
		$this->assertEqual(substr_count($result, "<div"), 2);
		$this->assertEqual(substr_count($result, "<a"), 1);
		$this->assertEqual(substr_count($result, "</a>"), 1);
		$this->assertEqual(substr_count($result, "</div>"), 1);	
	}
	
	function test_beginEditDiv_shouldAcceptVisibleParameter()
	{
		ob_start();
		$this->obj->beginEditDiv(true);
		$result = ob_get_clean();
		
		$this->assertEqual(strpos($result, "<div id=\"" . $this->obj->id() . "-editPanel\" class=\"editPanel\" style=\"display:none\">"), 0);
		$this->assertEqual(substr_count($result, "<div"), 2);
		$this->assertEqual(substr_count($result, "<a"), 1);
		$this->assertEqual(substr_count($result, "</a>"), 1);
		$this->assertEqual(substr_count($result, "</div>"), 1);	
	}
	
	function test_beginPluginDiv_shouldAddElements()
	{
		ob_start();
		$this->obj->beginPluginDiv();
		$result = ob_get_clean();
		
		$this->assertEqual(strpos($result, "<div class=\"WigbiUIPlugin UIPlugin " .$this->obj->id() ."\">"), 0);	
	}
	
	function test_beginViewDiv_shouldAddElements()
	{
		ob_start();
		$this->obj->beginViewDiv();
		$result = ob_get_clean();
		
		$this->assertEqual(strpos($result, "<div id=\"" . $this->obj->id() . "-viewPanel\" class=\"viewPanel\" style=\"display:none\">"), 0);
		$this->assertEqual(substr_count($result, "<div"), 2);
		$this->assertEqual(substr_count($result, "<a"), 1);
		$this->assertEqual(substr_count($result, "</a>"), 1);
		$this->assertEqual(substr_count($result, "</div>"), 1);		
	}
	
	function test_beginViewDiv_shouldAcceptVisibleParameter()
	{
		ob_start();
		$this->obj->beginViewDiv(false);
		$result = ob_get_clean();
		
		$this->assertEqual(strpos($result, "<div id=\"" . $this->obj->id() . "-viewPanel\" class=\"viewPanel\">"), 0);
		$this->assertEqual(substr_count($result, "<div"), 2);
		$this->assertEqual(substr_count($result, "<a"), 1);
		$this->assertEqual(substr_count($result, "</a>"), 1);
		$this->assertEqual(substr_count($result, "</div>"), 1);		
	}
	
	function test_endEditDiv_shouldAddElement()
	{
		ob_start();
		$this->obj->endEditDiv();
		$result = ob_get_clean();
		
		$this->assertEqual(strpos($result, "</div>"), 0);
	}
	
	function test_endPluginDiv_shouldAddElement()
	{
		ob_start();
		$this->obj->endPluginDiv();
		$result = ob_get_clean();
		
		$this->assertEqual(strpos($result, "</div>"), 0);
	}
	
	function test_endViewDiv_shouldAddElement()
	{
		ob_start();
		$this->obj->endViewDiv();
		$result = ob_get_clean();
		
		$this->assertEqual(strpos($result, "</div>"), 0);
	}
	
	function test_translate_shouldAppendPrefix()
	{
		$this->assertEqual($this->obj->translate("foo"), $this->id . " MyUIPlugin foo");
	}
}



//The base class is abstract - use this wrapper
class MyUIPlugin extends WigbiUIPlugin { }

?>