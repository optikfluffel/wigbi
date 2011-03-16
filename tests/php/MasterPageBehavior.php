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
	
	function test_filePath_shouldGetSetVariable()
	{
		$this->assertEqual(MasterPage::filePath(), "");
				
		MasterPage::filePath("foo");
		
		$this->assertEqual(MasterPage::filePath(), "foo");
	}
	
	
	
	function test_build_shouldExposeAllContentAreas()
	{
		MasterPage::openContentArea("content1");
		print "foo";
		MasterPage::closeContentArea();
		MasterPage::openContentArea("content2");
		print "bar";
		MasterPage::closeContentArea();
		
		ob_start();
		MasterPage::filePath(Wigbi::serverRoot() . "tests/resources/master.php");
		MasterPage::build();
		$data = ob_get_clean();
		
		$this->assertEqual($data, "foobar");
	}
	
	function test_closeContentArea_shouldEndOutputBuffering()
	{
		ob_start();
		print "foo";
		MasterPage::closeContentArea();
		$data = ob_get_clean();
		
		$this->assertEqual($data, "");
	}
	
	function test_getContent_shouldReturnEmptyStringForNonDefinedContentArea()
	{
		$this->assertEqual(MasterPage::getContent("nonDefinedContentArea"), "");
	}
	
	function test_getContent_shouldReturnEmptyStringForNonClosedContentArea()
	{
		MasterPage::openContentArea("myContent");
		$this->assertEqual(MasterPage::getContent("myContent"), "");
	}
	
	function test_getContent_shouldReturnCorrectStringForClosedContentArea()
	{
		MasterPage::openContentArea("myContent");
		print "foo";
		MasterPage::closeContentArea();
		
		$this->assertEqual(MasterPage::getContent("myContent"), "foo");
	}
	
	function test_openContentArea_shouldStartOutputBuffering()
	{
		MasterPage::openContentArea("myData", 10);
		print "foo";
		$data = ob_get_clean();
		
		$this->assertEqual($data, "foo");
	}
}

?>