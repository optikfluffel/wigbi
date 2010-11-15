<?php

class CountryBehavior extends UnitTestCase
{
	private $country;
	

	
	function CountryBehavior()
	{
		$this->UnitTestCase("Country data plugin");
	}
	
	function setUp()
	{
		$this->country = new Country();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->country->setupDatabase();
	}	
	

	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->country = new Country();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->country->className(), "Country");
		$this->assertEqual($this->country->collectionName(), "Countries");
		
		$this->assertEqual($this->country->name(), "__50");
		$this->assertEqual($this->country->latitude(), 0.0);
		$this->assertEqual($this->country->longitude(), 0.0);
		$this->assertEqual($this->country->languageCode(), "__10");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->country->className(), "Country");
		$this->assertEqual($this->country->collectionName(), "Countries");
		
		$this->assertEqual($this->country->name(), "");
		$this->assertEqual($this->country->latitude(), 0.0);
		$this->assertEqual($this->country->longitude(), 0.0);
		$this->assertEqual($this->country->languageCode(), "");
	}
			
	
    
	function test_properties_shouldBePersisted()
	{
		$this->country->name("name");
		$this->country->latitude(1.1);
		$this->country->longitude(2.2);
		$this->country->languageCode("sv-se");
		$this->country->save();
		
		$tmpObj = new Country();
		$tmpObj->load($this->country->id());
		
		$this->assertEqual($tmpObj->name(), "name");
		$this->assertEqual($tmpObj->latitude(), 1.1);
		$this->assertEqual($tmpObj->longitude(), 2.2);
		$this->assertEqual($tmpObj->languageCode(), "sv-se");
	}
	
	
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->country->name("       ");
		
		$this->assertEqual($this->country->validate(), array("nameRequired"));
		
		$this->country->name("foo bar");
		
		$this->assertEqual($this->country->validate(), array());
	}
}

?>