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
	
	function test_addFormClosingTag_shouldAddElement()
	{
		ob_start();
		View::addFormClosingTag();
		$result = ob_get_clean();
		
		$this->assertEqual($result, "</form>");	
	}
	
	function test_addFormOpeningTag_shouldAddElement()
	{
		ob_start();
		View::addFormOpeningTag("myForm", "myAction", "alert('submitted')", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<form id=\"myForm\" action=\"myAction\" onsubmit=\"alert('submitted')\" style=\"color:red\">");	
	}
	
	function test_addPasswordInput_shouldAddElement()
	{
		ob_start();
		View::addPasswordInput("myInput", "myPwd", "style=\"color:red\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<input type=\"password\" id=\"myInput\" value=\"myPwd\" style=\"color:red\" />");	
	}
	
	function test_addResetInput_shouldAddElement()
	{
		ob_start();
		View::addResetInput("myInput", "myText", "style=\"color:red\"");
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
	
	function test_addSubmitInput_shouldAddElement()
	{
		ob_start();
		View::addSubmitInput("myInput", "myText", "style=\"color:red\"");
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
	
	
	/*
	function test_addAttribute_shouldAddEmptyValueIfRequested()
	{
		$this->assertEqual(View::addAttribute("id", "", true), "id=\"\" ");
	}
	
	function test_addAttribute_shouldAddStringWithValue()
	{
		$this->assertEqual(View::addAttribute("id", "foobar"), "id=\"foobar\" ");
	}
	/*
	
	
	function test_addButton_shouldApplyId()
	{
		ob_start();
		View::addButton("myElem", "");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<button id=\"myElem\" ></button>");	
	}
	
	function test_addButton_shouldApplyText()
	{
		ob_start();
		View::addButton("myElem", "click me");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<button id=\"myElem\" >click me</button>");	
	}
	
	function test_addButton_shouldApplyOnClick()
	{
		ob_start();
		View::addButton("myElem", "click me", "alert('hello world!')");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<button id=\"myElem\" onclick=\"alert('hello world!')\" >click me</button>");	
	}
	
	function test_addButton_shouldApplyCustomAttributes()
	{
		ob_start();
		View::addButton("myElem", "click me", "alert('hello world!')", "class=\"myClass\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<button id=\"myElem\" onclick=\"alert('hello world!')\" class=\"myClass\">click me</button>");	
	}
	
	function test_addPasswordBox_shouldHandleBlankParameters()
	{
		ob_start();
		View::addPasswordBox("", "");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<input type=\"password\"  />");	
	}
	
	function test_addPasswordBox_shouldApplyId()
	{
		ob_start();
		View::addPasswordBox("myElem", "");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<input type=\"password\" id=\"myElem\"  />");	
	}
	
	function test_addPasswordBox_shouldApplyValue()
	{
		ob_start();
		View::addPasswordBox("myElem", "myPwd");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<input type=\"password\" id=\"myElem\" value=\"myPwd\"  />");	
	}
	
	function test_addPasswordBox_shouldApplyCustomAttributes()
	{
		ob_start();
		View::addPasswordBox("myElem", "myPwd", "class=\"myClass\"");
		$result = ob_get_clean();
		
		$this->assertEqual($result, "<input type=\"password\" id=\"myElem\" value=\"myPwd\" class=\"myClass\" />");
	}
	
	/*
	
	function test_addButton_shouldAddElement()
	{
		ob_start();
		$this->obj->addButton("myElem", "foo(0)", "Click me", "hide");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<button id="' . $this->obj->id() . '-myElem" class="hide" onclick="' . $this->obj->id() . '.foo(0)">Click me</button>');	
	}
	
	function test_addButton_shouldCompleteMethodIfNeeded()
	{
		ob_start();
		$this->obj->addButton("myElem", "foo", "Click me", "hide");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<button id="' . $this->obj->id() . '-myElem" class="hide" onclick="' . $this->obj->id() . '.foo()">Click me</button>');	
	}
	
	function test_addPasswordBox_shouldAddElementWithoutCaptionAndClass()
	{
		ob_start();
		$this->obj->addPasswordBox("myPasswordBox", "foo bar");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<input type="password" id="' . $this->obj->id() . '-myPasswordBox" class="" value="foo bar" />');	
	}
	
	function test_addPasswordBox_shouldAddElementWithCaptionAndClass()
	{
		ob_start();
		$this->obj->addPasswordBox("myPasswordBox", "foo bar", "Stuff:", "hide");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<div id="' . $this->obj->id() . '-myPasswordBox-title" class="title">Stuff:</div><input type="password" id="' . $this->obj->id() . '-myPasswordBox" class="hide" value="foo bar" />');	
	}
	
	function test_addText_shouldAddElementWithoutClass()
	{
		ob_start();
		$this->obj->addText("myText", "foo bar");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<div id="' . $this->obj->id() . '-myText" class="">foo bar</div>');	
	}
	
	function test_addText_shouldAddElementWithClass()
	{
		ob_start();
		$this->obj->addText("myText", "foo bar", "hide");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<div id="' . $this->obj->id() . '-myText" class="hide">foo bar</div>');	
	}
	
	function test_addTextArea_shouldAddElementWithoutCaptionAndClass()
	{
		ob_start();
		$this->obj->addTextArea("myTextArea", "foo bar");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<textarea id="' . $this->obj->id() . '-myTextArea" class="">foo bar</textarea>');	
	}
	
	function test_addTextArea_shouldAddElementWithCaptionAndClass()
	{
		ob_start();
		$this->obj->addTextArea("myTextArea", "foo bar", "Stuff:", "hide");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<div id="' . $this->obj->id() . '-myTextArea-title" class="title">Stuff:</div><textarea id="' . $this->obj->id() . '-myTextArea" class="hide">foo bar</textarea>');	
	}
	
	function test_addTextBox_shouldAddElementWithoutCaptionAndClass()
	{
		ob_start();
		$this->obj->addTextBox("myTextBox", "foo bar");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<input type="text" id="' . $this->obj->id() . '-myTextBox" class="" value="foo bar" />');	
	}
	
	function test_addTextBox_shouldAddElementWithCaptionAndClass()
	{
		ob_start();
		$this->obj->addTextBox("myTextBox", "foo bar", "Stuff:", "hide");
		$result = ob_get_clean();
		
		$this->assertEqual($result, '<div id="' . $this->obj->id() . '-myTextBox-title" class="title">Stuff:</div><input type="text" id="' . $this->obj->id() . '-myTextBox" class="hide" value="foo bar" />');	
	}
	
	*/
	
	
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
}

?>