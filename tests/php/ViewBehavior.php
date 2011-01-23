<?php

class ViewBehavior extends UnitTestCase
{
	function ViewBehavior()
	{
		$this->UnitTestCase("View");
	}


	
	function test_model_shouldBeNullOutsideOfView()
	{
		$value = View::model("key");
		
		$this->assertNull($value);
	}
	
	function test_viewData_shouldReturnNullForNonExistingKey()
	{
		$value = View::viewData("nonexisting");
		
		$this->assertNull($value);
	}
	
	function test_viewData_shouldGetSetValue()
	{
		$originalValue = View::viewData("foo");
		$setValue = View::viewData("foo", "bar");
		$resultValue = View::viewData("foo");
		
		$this->assertEqual($originalValue, "");
		$this->assertEqual($setValue, "bar");
		$this->assertEqual($resultValue, "bar");
	}
	
	function test_addView_shouldHandleNonSetModel()
	{
		ob_start();
		View::addView(Wigbi::serverRoot() . "tests/resources/view.php");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "");
	}
	
	function test_addView_shouldHandleModel()
	{
		ob_start();
		View::addView(Wigbi::serverRoot() . "tests/resources/view.php", "foo bar");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "foo bar");
	}
	
	function test_addView_shouldHandleExistingModel()
	{
		ob_start();
		View::addView(Wigbi::serverRoot() . "tests/resources/nestingView.php", "bar");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "foo bar");
	}
	
	function test_addView_shouldHandleTilde()
	{
		ob_start();
		View::addView("~/tests/resources/view.php", "foo bar");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "foo bar");
	}
}

?>