<?php

class MessageBehavior extends UnitTestCase
{
	private $message;
	
	
	function MessageBehavior()
	{
		$this->UnitTestCase("Message data plugin");
	}
	
	function setUp()
	{
		$this->message = new Message();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->message->setupDatabase();
	}	
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->message = new Message();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->message->className(), "Message");
		$this->assertEqual($this->message->collectionName(), "Messages");
		
		$this->assertEqual($this->message->senderId(), "__GUID");
		$this->assertEqual($this->message->receiverId(), "__GUID");
		$this->assertEqual($this->message->createdDateTime(), "__DATETIME");
		$this->assertEqual($this->message->subject(), "__50");
		$this->assertEqual($this->message->text(), "__TEXT");
		$this->assertEqual($this->message->isRead(), false);
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->message->className(), "Message");
		$this->assertEqual($this->message->collectionName(), "Messages");
		
		$this->assertEqual($this->message->senderId(), "");
		$this->assertEqual($this->message->receiverId(), "");
		$this->assertEqual($this->message->createdDateTime(), "");
		$this->assertEqual($this->message->subject(), "");
		$this->assertEqual($this->message->text(), "");
		$this->assertEqual($this->message->isRead(), false);
	}
			
	    
	
	function test_properties_shouldBePersisted()
	{
		$this->message->senderId("sender");
		$this->message->receiverId("receiver");
		$this->message->subject("subject");
		$this->message->text("text");
		$this->message->isRead(true);
		$this->message->save();
		
		$tmpObj = new Message();
		$tmpObj->load($this->message->id());
		
		$this->assertEqual($tmpObj->senderId(), "sender");
		$this->assertEqual($tmpObj->receiverId(), "receiver");
		$this->assertTrue($tmpObj->createdDateTime());
		$this->assertEqual($tmpObj->subject(), "subject");
		$this->assertEqual($tmpObj->text(), "text");
		$this->assertEqual($tmpObj->isRead(), true);
	}
	
    
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->message->subject("       ");
		$this->message->text("          ");
		
		$this->assertEqual($this->message->validate(), array("subject_required", "text_required"));
		
		$this->message->subject("foo bar");
		
		$this->assertEqual($this->message->validate(), array("text_required"));
		
		$this->message->text("foo bar");
		
		$this->assertEqual($this->message->validate(), array());
	}
}

?>