<?php

class GuestbookEntryBehavior extends UnitTestCase
{
	private $guestbookEntry;
	
	
	
	function GuestbookEntryBehavior()
	{
		$this->UnitTestCase("GuestbookEntry data plugin");
	}
	
	function setUp()
	{
		$this->guestbookEntry = new GuestbookEntry();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->guestbookEntry->setupDatabase();
	}	
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->guestbookEntry = new GuestbookEntry();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->guestbookEntry->className(), "GuestbookEntry");
		$this->assertEqual($this->guestbookEntry->collectionName(), "GuestbookEntries");
		
		$this->assertEqual($this->guestbookEntry->senderId(), "__GUID");
		$this->assertEqual($this->guestbookEntry->receiverId(), "__GUID");
		$this->assertEqual($this->guestbookEntry->createdDateTime(), "__DATETIME");
		$this->assertEqual($this->guestbookEntry->text(), "__TEXT");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->guestbookEntry->className(), "GuestbookEntry");
		$this->assertEqual($this->guestbookEntry->collectionName(), "GuestbookEntries");
		
		$this->assertEqual($this->guestbookEntry->senderId(), "");
		$this->assertEqual($this->guestbookEntry->receiverId(), "");
		$this->assertEqual($this->guestbookEntry->createdDateTime(), "");
		$this->assertEqual($this->guestbookEntry->text(), "");
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->guestbookEntry->senderId("sender");
		$this->guestbookEntry->receiverId("receiver");
		$this->guestbookEntry->text("foo bar");
		$this->guestbookEntry->save();
		
		$tmpObj = new GuestbookEntry();
		$tmpObj->load($this->guestbookEntry->id());
		
		$this->assertEqual($tmpObj->senderId(), "sender");
		$this->assertEqual($tmpObj->receiverId(), "receiver");
		$this->assertTrue($tmpObj->createdDateTime());
		$this->assertEqual($tmpObj->text(), "foo bar");
	}
	
    
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->guestbookEntry->text("       ");
		
		$this->assertEqual($this->guestbookEntry->validate(), array("textRequired"));
		
		$this->guestbookEntry->text("foo bar");
		
		$this->assertEqual($this->guestbookEntry->validate(), array());
	}
}

?>