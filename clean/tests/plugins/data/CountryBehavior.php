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
	

	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->country = new Country();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->country->className(), "Country");
		$this->assertEqual($this->country->collectionName(), "Countries");
		
		$this->assertEqual($this->country->name(), "__50");
		$this->assertEqual($this->country->languageCode(), "__10");
		$this->assertEqual($this->country->languageName(), "__25");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->country->className(), "Country");
		$this->assertEqual($this->country->collectionName(), "Countries");
		
		$this->assertEqual($this->country->name(), "");
		$this->assertEqual($this->country->languageCode(), "");
		$this->assertEqual($this->country->languageName(), "");
	}
			
	
    
	function test_properties_shouldBePersisted()
	{
		$this->country->name("Sverige");
		$this->country->languageCode("sv");
		$this->country->languageName("Svenska");
		
		$this->country->save();
		
		$tmpObj = new Country();
		$tmpObj->load($this->country->id());
		
		$this->assertEqual($tmpObj->name(), "Sverige");
		$this->assertEqual($tmpObj->languageCode(), "sv");
		$this->assertEqual($tmpObj->languageName(), "Svenska");
	}
	
	
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->country->name("       ");
		
		$this->assertEqual($this->country->validate(), array("name_required"));
		
		$this->country->name("foo bar");
		
		$this->assertEqual($this->country->validate(), array());
	}
}

?>