<?php

class ViewBehavior extends UnitTestCase
{
	function ViewBehavior()
	{
		$this->UnitTestCase("View");
	}


	
	function test_viewData_currentViewDataShouldNotExistOutsideOfView()
	{
		$value = View::viewData();
		
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
	
	
	function test_addButton_shouldAddElement()
	{
		ob_start();
		View::addButton("myButton", "click me", "alert('hello world')", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<button id=\"myButton\" onclick=\"alert('hello world')\" style=\"color:red\" >click me</button>");	
	}
	
	function test_addDiv_shouldAddElement()
	{
		ob_start();
		View::addDiv("myDiv", "content", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<div id=\"myDiv\" style=\"color:red\" >content</div>");	
	}
	
	function test_addElement_shouldAddEmptyElement()
	{
		ob_start();
		View::addElement("");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "< />");
	}
	
	function test_addElement_shouldAddTypedElement()
	{
		ob_start();
		View::addElement("img");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<img />");
	}
	
	function test_addElement_shouldApplyAttributes()
	{
		ob_start();
		View::addElement("img", array("id" => "myElement", "class" => "myClass"));
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<img id=\"myElement\" class=\"myClass\" />");
	}
	
	function test_addElement_shouldApplyCustomAttributes()
	{
		ob_start();
		View::addElement("img", array("id" => "myElement", "class" => "myClass"), "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<img id=\"myElement\" class=\"myClass\" style=\"color:red\" />");
	}
	
	function test_addElement_shouldApplyElementBody()
	{
		ob_start();
		View::addElement("div", array("id" => "myElement", "class" => "myClass"), "", "myContent");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<div id=\"myElement\" class=\"myClass\" >myContent</div>");
	}
	
	function test_addPasswordInput_shouldAddElement()
	{
		ob_start();
		View::addPasswordInput("myInput", "myPwd", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<input type=\"password\" id=\"myInput\" value=\"myPwd\" style=\"color:red\" />");	
	}
	
	function test_addResetButton_shouldAddElement()
	{
		ob_start();
		View::addResetButton("myInput", "myText", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<input type=\"reset\" id=\"myInput\" value=\"myText\" style=\"color:red\" />");	
	}
	
	function test_addSpan_shouldAddElement()
	{
		ob_start();
		View::addSpan("mySpan", "content", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<span id=\"mySpan\" style=\"color:red\" >content</span>");	
	}
	
	function test_addSubmitButton_shouldAddElement()
	{
		ob_start();
		View::addSubmitButton("myInput", "myText", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<input type=\"submit\" id=\"myInput\" value=\"myText\" style=\"color:red\" />");	
	}
	
	function test_addTextArea_shouldAddElement()
	{
		ob_start();
		View::addTextArea("myArea", "myContent", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<textarea id=\"myArea\" style=\"color:red\" >myContent</textarea>");	
	}
	
	function test_addTextInput_shouldAddElement()
	{
		ob_start();
		View::addTextInput("myInput", "myText", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<input type=\"text\" id=\"myInput\" value=\"myText\" style=\"color:red\" />");	
	}
	
	function test_addView_shouldHandleNonExistingCurrentViewData()
	{
		ob_start();
		View::addView(Wigbi::serverRoot() . "tests/resources/view.php");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "");
	}
	
	function test_addView_shouldHandleExistingCurrentViewData()
	{
		ob_start();
		View::addView(Wigbi::serverRoot() . "tests/resources/view.php", "foo bar");
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
	
	function test_closeForm_shouldAddElement()
	{
		ob_start();
		View::closeFOrm();
		$result = ob_get_clean();
		
		$this->assertEqual($result, "</form>");	
	}
	
	function test_openForm_shouldAddElement()
	{
		ob_start();
		View::openForm("myForm", "myAction", "alert('submitted')", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<form id=\"myForm\" action=\"myAction\" onsubmit=\"alert('submitted')\" style=\"color:red\">");	
	}
}

?>