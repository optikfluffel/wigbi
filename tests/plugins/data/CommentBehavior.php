<?php

class CommentBehavior extends UnitTestCase
{	
	private $comment;
	


	function CommentBehavior()
	{
		$this->UnitTestCase("Comment data plugin");
	}
	
	function setUp()
	{
		$this->comment = new Comment();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->comment = new Comment();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->comment->className(), "Comment");
		$this->assertEqual($this->comment->collectionName(), "Comments");
		
		$this->assertEqual($this->comment->authorId(), "__GUID");
		$this->assertEqual($this->comment->authorName(), "__50");
		$this->assertEqual($this->comment->authorEmail(), "__50");
		$this->assertEqual($this->comment->authorUrl(), "__50");
		$this->assertEqual($this->comment->receiverId(), "__GUID");
		$this->assertEqual($this->comment->receiverName(), "__50");
		$this->assertEqual($this->comment->text(), "__TEXT");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->comment->className(), "Comment");
		$this->assertEqual($this->comment->collectionName(), "Comments");
		
		$this->assertEqual($this->comment->authorId(), "");
		$this->assertEqual($this->comment->authorName(), "");
		$this->assertEqual($this->comment->authorEmail(), "");
		$this->assertEqual($this->comment->authorUrl(), "");
		$this->assertEqual($this->comment->receiverId(), "");
		$this->assertEqual($this->comment->receiverName(), "");
		$this->assertEqual($this->comment->text(), "");
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->comment->authorId("id");
		$this->comment->authorName("name");
		$this->comment->authorEmail("e-mail");
		$this->comment->authorUrl("url");
		$this->comment->receiverId("receiver id");
		$this->comment->receiverName("receiver");
		$this->comment->text("foo bar");
		$this->comment->save();
		
		$tmpObj = new Comment();
		$tmpObj->load($this->comment->id());
		
		$this->assertEqual($tmpObj->authorId(), "id");
		$this->assertEqual($tmpObj->authorName(), "name");
		$this->assertEqual($tmpObj->authorEmail(), "e-mail");
		$this->assertEqual($tmpObj->authorUrl(), "url");
		$this->assertEqual($tmpObj->receiverId(), "receiver id");
		$this->assertEqual($tmpObj->receiverName(), "receiver");
		$this->assertEqual($tmpObj->text(), "foo bar");
	}
	
    
    
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->comment->authorEmail("foo bar");
		
		$this->assertEqual($this->comment->validate(), array("email_invalid", "text_required"));
		
		$this->comment->authorEmail("foo@bar.se");
		$this->comment->text("       ");
		
		$this->assertEqual($this->comment->validate(), array("text_required"));
		
		$this->comment->text("foo bar");
		
		$this->assertEqual($this->comment->validate(), array());
	}
}

?>