<?php

class CityBehavior extends UnitTestCase
{
	private $city;
	
	
	
	function CityBehavior()
	{
		$this->UnitTestCase("City data plugin");
	}
	
	function setUp()
	{
		$this->city = new City();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->city->setupDatabase();
	}	
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->city = new City();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->city->className(), "City");
		$this->assertEqual($this->city->collectionName(), "Cities");
		
		$this->assertEqual($this->city->name(), "__50");
		$this->assertEqual($this->city->latitude(), 0.0);
		$this->assertEqual($this->city->longitude(), 0.0);
		$this->assertEqual($this->city->countryId(), "__GUID");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->city->className(), "City");
		$this->assertEqual($this->city->collectionName(), "Cities");
		
		$this->assertEqual($this->city->name(), "");
		$this->assertEqual($this->city->latitude(), 0.0);
		$this->assertEqual($this->city->longitude(), 0.0);
		$this->assertEqual($this->city->countryId(), "");
	}
			


	function test_properties_shouldBePersisted()
	{
		$this->city->name("name");
		$this->city->latitude(1.1);
		$this->city->longitude(2.2);
		$this->city->countryId("country");
		$this->city->save();
		
		$tmpObj = new City();
		$tmpObj->load($this->city->id());
		
		$this->assertEqual($tmpObj->name(), "name");
		$this->assertEqual($tmpObj->latitude(), 1.1);
		$this->assertEqual($tmpObj->longitude(), 2.2);
		$this->assertEqual($tmpObj->countryId(), "country");
	}
	
    
    
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->city->name("       ");
		
		$this->assertEqual($this->city->validate(), array("name_required"));
		
		$this->city->name("foo bar");
		
		$this->assertEqual($this->city->validate(), array());
	}
}

?>