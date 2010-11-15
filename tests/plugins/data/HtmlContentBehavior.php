<?php

class HtmlContentBehavior extends UnitTestCase
{
	private $htmlContent;
	
	
	function HtmlContentBehavior()
	{
		$this->UnitTestCase("HtmlContent data plugin");
	}
	
	function setUp()
	{
		$this->htmlContent = new HtmlContent();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->htmlContent->setupDatabase();
	}	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->htmlContent = new HtmlContent();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->htmlContent->className(), "HtmlContent");
		$this->assertEqual($this->htmlContent->collectionName(), "HtmlContents");
		
		$this->assertEqual($this->htmlContent->createdDateTime(), "__DATETIME");
		$this->assertEqual($this->htmlContent->lastUpdatedDateTime(), "__DATETIME");
		$this->assertEqual($this->htmlContent->name(), "__50");
		$this->assertEqual($this->htmlContent->content(), "__TEXT");
    }
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->htmlContent->className(), "HtmlContent");
		$this->assertEqual($this->htmlContent->collectionName(), "HtmlContents");
		
		$this->assertEqual($this->htmlContent->createdDateTime(), "");
		$this->assertEqual($this->htmlContent->lastUpdatedDateTime(), "");
		$this->assertEqual($this->htmlContent->name(), "");
		$this->assertEqual($this->htmlContent->content(), "");
    }
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->htmlContent->name("name");
		$this->htmlContent->content("content");
		$this->htmlContent->save();
		
		$tmpObj = new HtmlContent();
		$tmpObj->load($this->htmlContent->id());
		
		$this->assertTrue($tmpObj->createdDateTime());
		$this->assertTrue($tmpObj->lastUpdatedDateTime());
		$this->assertEqual($tmpObj->name(), "name");
		$this->assertEqual($tmpObj->content(), "content");
    }
	
    
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->htmlContent->name("       ");
		
		$this->assertEqual($this->htmlContent->validate(), array("nameRequired"));
		
		$this->htmlContent->name("foo bar");
		
		$this->assertEqual($this->htmlContent->validate(), array());
    }
} ?>