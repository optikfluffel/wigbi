<?php

class ForumPostBehavior extends UnitTestCase
{
	private $forumPost;
	

	
	function ForumPostBehavior()
	{
		$this->UnitTestCase("ForumPost data plugin");
	}
	
	function setUp()
	{
		$this->forumPost = new ForumPost();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->forumPost->setupDatabase();
	}	
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->forumPost = new ForumPost();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->forumPost->className(), "ForumPost");
		$this->assertEqual($this->forumPost->collectionName(), "ForumPosts");
		
		$this->assertEqual($this->forumPost->createdById(), "__GUID");
		$this->assertEqual($this->forumPost->createdDateTime(), "__DATETIME");
		$this->assertEqual($this->forumPost->lastUpdatedDateTime(), "__DATETIME");
		$this->assertEqual($this->forumPost->forumThreadId(), "__GUID");
		$this->assertEqual($this->forumPost->content(), "__TEXT");
  }
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->forumPost->className(), "ForumPost");
		$this->assertEqual($this->forumPost->collectionName(), "ForumPosts");
		
		$this->assertEqual($this->forumPost->createdById(), "");
		$this->assertEqual($this->forumPost->createdDateTime(), "");
		$this->assertEqual($this->forumPost->lastUpdatedDateTime(), "");
		$this->assertEqual($this->forumPost->forumThreadId(), "");
		$this->assertEqual($this->forumPost->content(), "");
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->forumPost->createdById("created by");
		$this->forumPost->forumThreadId("forum thread");
		$this->forumPost->content("content");
		$this->forumPost->save();
		
		$tmpObj = new ForumPost();
		$tmpObj->load($this->forumPost->id());
		
		$this->assertEqual($tmpObj->createdById(), "created by");
		$this->assertEqual($tmpObj->forumThreadId(), "forum thread");
		$this->assertTrue($tmpObj->createdDateTime());
		$this->assertTrue($tmpObj->lastUpdatedDateTime());
		$this->assertEqual($tmpObj->content(), "content");
	}
	
    
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->forumPost->content("       ");
		
		$this->assertEqual($this->forumPost->validate(), array("content_required"));
		
		$this->forumPost->content("foo bar");
		
		$this->assertEqual($this->forumPost->validate(), array());
	}
}

?>