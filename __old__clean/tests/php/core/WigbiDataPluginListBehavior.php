<?php

class WigbiDataPluginListBehavior extends UnitTestCase
{
	private $list;
	private $customList;
	
	
	
	function WigbiDataPluginListBehavior()
	{
		$this->UnitTestCase("WigbiDataPluginList");
	}
	
	function setUp() { }
	
	function tearDown() { }
	

	
	function test_constructor_shouldCreateObjectWithMinimumParameters()
	{
		$list = new WigbiDataPluginList("images", "User", "Image");
		
		$this->assertEqual($list->name(), "images");
		$this->assertEqual($list->ownerClass(), "User");
		$this->assertEqual($list->itemClass(), "Image");
		$this->assertFalse($list->isSynced());
		$this->assertEqual($list->sortRule(), null);
		$this->assertEqual($list->tableName(), "User_images");
	}
	
	function test_constructor_shouldCreateObjectWithAllParameters()
	{
		$list = new WigbiDataPluginList("images", "User", "Image", true, "name() DESC");
		
		$this->assertEqual($list->name(), "images");
		$this->assertEqual($list->ownerClass(), "User");
		$this->assertEqual($list->itemClass(), "Image");
		$this->assertTrue($list->isSynced());
		$this->assertEqual($list->sortRule(), "name() DESC");
		$this->assertEqual($list->tableName(), "User_images");
	}
			
	
	
	function test_ownerId_shouldGetAndSetValue()
	{
		$list = new WigbiDataPluginList("images", "User", "Image");
		
		$this->assertNull($list->ownerId());
		$this->assertNull($list->ownerId());
		$this->assertEqual($list->ownerId("123456"), "123456");
		$this->assertEqual($list->ownerId(), "123456");
	}
}

?>