<?php

class WigbiDataPluginListBehavior extends UnitTestCase
{
	private $defaultList;
	private $customList;
	
	
	
	function WigbiDataPluginListBehavior()
	{
		$this->UnitTestCase("WigbiDataPluginList");
	}
	
	function setUp()
	{
		$this->defaultList = new WigbiDataPluginList("images", "User", "Image");
		$this->customList = new WigbiDataPluginList("images", "User", "Image", true, "name() DESC");
	}
	
	function tearDown() { }
	

	
	function test_constructor_shouldCreateDefaultObject()
	{
		$this->assertEqual($this->defaultList->name(), "images");
		$this->assertEqual($this->defaultList->ownerClass(), "User");
		$this->assertEqual($this->defaultList->itemClass(), "Image");
		$this->assertFalse($this->defaultList->isSynced());
		$this->assertEqual($this->defaultList->sortRule(), null);
	}
	
	function test_constructor_shouldCreateCustomObject()
	{
		$this->assertEqual($this->customList->name(), "images");
		$this->assertEqual($this->customList->ownerClass(), "User");
		$this->assertEqual($this->customList->itemClass(), "Image");
		$this->assertTrue($this->customList->isSynced());
		$this->assertEqual($this->customList->sortRule(), "name() DESC");
	}
			
	
	
	function test_isSynced_shouldReturnDefaultAndCustomValue()
	{
		$this->assertFalse($this->defaultList->isSynced());
		$this->assertTrue($this->customList->isSynced());
	}
	
	function test_itemClass_shouldReturnDefaultAndCustomValue()
	{
		$this->assertEqual($this->defaultList->itemClass(), "Image");
		$this->assertEqual($this->customList->itemClass(), "Image");
	}
	
	function test_name_shouldReturnDefaultAndCustomValue()
	{
		$this->assertEqual($this->defaultList->name(), "images");
		$this->assertEqual($this->customList->name(), "images");
	}
	
	function test_ownerClass_shouldReturnDefaultAndCustomValue()
	{
		$this->assertEqual($this->defaultList->ownerClass(), "User");
		$this->assertEqual($this->customList->ownerClass(), "User");
	}
	
	function test_ownerId_shouldGetAndSetValue()
	{
		$this->assertNull($this->defaultList->ownerId());
		$this->assertNull($this->customList->ownerId());
		$this->assertEqual($this->defaultList->ownerId("123456"), "123456");
		$this->assertEqual($this->defaultList->ownerId(), "123456");
	}
	
	function test_sortRule_shouldReturnDefaultAndCustomValue()
	{
		$this->assertNull($this->defaultList->sortRule());
		$this->assertEqual($this->customList->sortRule(), "name() DESC");
	}
	
	function test_tableName_shouldReturnConcatenatedValue()
	{
		$this->assertEqual($this->defaultList->tableName(), "User_images");
		$this->assertEqual($this->customList->tableName(), "User_images");
	}
}

?>