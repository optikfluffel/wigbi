<?php

class NewsBehavior extends UnitTestCase
{
	private $news;
	
	
	function NewsBehavior()
	{
		$this->UnitTestCase("News data plugin");
	}
	
	function setUp()
	{
		$this->news = new News();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->news->setupDatabase();
	}	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->news = new News();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->news->className(), "News");
		$this->assertEqual($this->news->collectionName(), "Newss");
		
		$this->assertEqual($this->news->createdDateTime(), "__DATETIME");
		$this->assertEqual($this->news->lastUpdatedDateTime(), "__DATETIME");
		$this->assertEqual($this->news->title(), "__50");
		$this->assertEqual($this->news->content(), "__TEXT");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->news->className(), "News");
		$this->assertEqual($this->news->collectionName(), "Newss");
		
		$this->assertEqual($this->news->createdDateTime(), "");
		$this->assertEqual($this->news->lastUpdatedDateTime(), "");
		$this->assertEqual($this->news->title(), "");
		$this->assertEqual($this->news->content(), "");
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->news->title("title");
		$this->news->content("content");
		$this->news->save();
		
		$tmpObj = new News();
		$tmpObj->load($this->news->id());
		
		$this->assertTrue($tmpObj->createdDateTime());
		$this->assertTrue($tmpObj->lastUpdatedDateTime());
		$this->assertEqual($tmpObj->title(), "title");
		$this->assertEqual($tmpObj->content(), "content");
	}
	
    
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->news->title("       ");
		
		$this->assertEqual($this->news->validate(), array("title_required"));
		
		$this->news->title("foo bar");
		
		$this->assertEqual($this->news->validate(), array());
	}
}

?>