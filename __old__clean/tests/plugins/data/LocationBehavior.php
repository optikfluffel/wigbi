<?php

class LocationBehavior extends UnitTestCase
{
	private $htmlContent;
	
	
	
	function LocationBehavior()
	{
		$this->UnitTestCase("Location data plugin");
	}
	
	function setUp()
	{
		$this->htmlContent = new Location();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->htmlContent = new Location();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->htmlContent->className(), "Location");
		$this->assertEqual($this->htmlContent->collectionName(), "Locations");
		
		$this->assertEqual($this->htmlContent->name(), "__50");
		$this->assertEqual($this->htmlContent->description(), "__TEXT");
		$this->assertEqual($this->htmlContent->latitude(), 0.0);
		$this->assertEqual($this->htmlContent->longitude(), 0.0);
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->htmlContent->className(), "Location");
		$this->assertEqual($this->htmlContent->collectionName(), "Locations");
		
		$this->assertEqual($this->htmlContent->name(), "");
		$this->assertEqual($this->htmlContent->description(), "");
		$this->assertEqual($this->htmlContent->latitude(), 0.0);
		$this->assertEqual($this->htmlContent->longitude(), 0.0);
	}
			

    
	function test_properties_shouldBePersisted()
	{
		$this->htmlContent->name("name");
		$this->htmlContent->description("description");
		$this->htmlContent->latitude(1.1);
		$this->htmlContent->longitude(2.2);
		$this->htmlContent->save();
		
		$tmpObj = new Location();
		$tmpObj->load($this->htmlContent->id());
		
		$this->assertEqual($tmpObj->name(), "name");
		$this->assertEqual($tmpObj->description(), "description");
		$this->assertEqual($tmpObj->latitude(), 1.1);
		$this->assertEqual($tmpObj->longitude(), 2.2);
	}
	
    
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->assertEqual($this->htmlContent->validate(), array());
	}
}

?>