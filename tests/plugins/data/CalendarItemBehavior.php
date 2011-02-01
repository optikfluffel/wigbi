<?php

class CalendarItemBehavior extends UnitTestCase
{
	private $calendarItem;
	

	
	function CalendarItemBehavior()
	{
		$this->UnitTestCase("CalendarItem data plugin");
	}
	
	function setUp()
	{
		$this->calendarItem = new CalendarItem();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->calendarItem = new CalendarItem();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->calendarItem->className(), "CalendarItem");
		$this->assertEqual($this->calendarItem->collectionName(), "CalendarItems");
	
		$this->assertEqual($this->calendarItem->title(), "__50");
		$this->assertEqual($this->calendarItem->startDateTime(), "__DATETIME");
		$this->assertEqual($this->calendarItem->endDateTime(), "__DATETIME");
		$this->assertEqual($this->calendarItem->fullDay(), true);
		$this->assertEqual($this->calendarItem->description(), "__TEXT");
  }
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->calendarItem->className(), "CalendarItem");
		$this->assertEqual($this->calendarItem->collectionName(), "CalendarItems");
		
		$this->assertEqual($this->calendarItem->title(), "");
		$this->assertEqual($this->calendarItem->startDateTime(), "");
		$this->assertEqual($this->calendarItem->endDateTime(), "");
		$this->assertEqual($this->calendarItem->fullDay(), true);
		$this->assertEqual($this->calendarItem->description(), "");
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->calendarItem->title("foo");
		$this->calendarItem->startDateTime("2011-10-01");
		$this->calendarItem->endDateTime("2011-10-02");
		$this->calendarItem->fullDay(false);
		$this->calendarItem->description("bar");

		$this->calendarItem->save();
		
		$tmpObj = new CalendarItem();
		$tmpObj->load($this->calendarItem->id());
		
		$this->assertEqual($tmpObj->title(), "foo");
		$this->assertEqual($tmpObj->startDateTime(), "2011-10-01 00:00:00");
		$this->assertEqual($tmpObj->endDateTime(), "2011-10-02 00:00:00");
		$this->assertFalse($tmpObj->fullDay());
		$this->assertEqual($tmpObj->description(), "bar");
	}
	
    
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->calendarItem->title("       ");
		
		$this->assertEqual($this->calendarItem->validate(), array("title_required", "startDateTime_required"));
		
		$this->calendarItem->title("foo bar");
		$this->calendarItem->startDateTime("    ");
		
		$this->assertEqual($this->calendarItem->validate(), array("startDateTime_required"));
		
		$this->calendarItem->startDateTime("2011-01-01 00:00:00");
		
		$this->assertEqual($this->calendarItem->validate(), array());
	}
}

?>