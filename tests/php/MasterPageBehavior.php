<?php

class MasterPageBehavior extends UnitTestCase
{
	function MasterPageBehavior()
	{
		$this->UnitTestCase("MasterPage");
	}



	function test_contentAreas_shouldReturnCorrectType()
	{
		$this->assertEqual(gettype(MasterPage::contentAreas()), "array");
	}
	
	function test_variables_shouldReturnCorrectType()
	{
		$this->assertEqual(gettype(MasterPage::variables()), "array");
	}
	
	
	
	function test_build_shouldExposeAllContentAreasAndVariables()
	{
		MasterPage::open("content1");
		print "foo";
		MasterPage::close();
		MasterPage::open("content2");
		print "bar";
		MasterPage::close();
		
		MasterPage::variable("variable1", true);
		MasterPage::variable("variable2", "name");
		MasterPage::variable("variable3", 1.0);
		
		ob_start();
		MasterPage::build(Wigbi::serverRoot() . "tests/resources/master.php");
		$data = ob_get_clean();
		
		$this->assertEqual($data, "foo" . "bar" . true . "name" . 1.0);
	}
	
	function test_close_shouldEndOutputBuffering()
	{
		ob_start();
		print "foo";
		MasterPage::close();
		$data = ob_get_clean();
		
		$this->assertEqual($data, "");
	}
	
	function test_content_shouldReturnEmptyStringForNonDefinedContentArea()
	{
		$this->assertEqual(MasterPage::content("nonDefinedContentArea"), "");
	}
	
	function test_content_shouldReturnEmptyStringForNonClosedContentArea()
	{
		MasterPage::open("myContent");
		$this->assertEqual(MasterPage::content("myContent"), "");
	}
	
	function test_content_shouldReturnCorrectStringForClosedContentArea()
	{
		MasterPage::open("myContent");
		print "foo";
		MasterPage::close();
		
		$this->assertEqual(MasterPage::content("myContent"), "foo");
	}
	
	function test_open_shouldStartOutputBuffering()
	{
		MasterPage::open("myData", 10);
		print "foo";
		$data = ob_get_clean();
		
		$this->assertEqual($data, "foo");
	}
	
	function test_variable_shouldGetSetVariable()
	{
		$this->assertEqual(MasterPage::variable("myVariable"), "");
				
		MasterPage::variable("myVariable", "foo");
		
		$this->assertEqual(MasterPage::variable("myVariable"), "foo");
	}
}

?>