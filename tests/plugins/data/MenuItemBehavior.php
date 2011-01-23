<?php

class MenuItemBehavior extends UnitTestCase
{
	private $menuItem;
	private $subMenuItem;
	private $menuItemPost;
	
	
	
	function MenuItemBehavior()
	{
		$this->UnitTestCase("MenuItem data plugin");
	}
	
	function setUp()
	{
		$this->menuItem = new MenuItem();
		$this->subMenuItem = new MenuItem();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->menuItem = new MenuItem();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->menuItem->className(), "MenuItem");
		$this->assertEqual($this->menuItem->collectionName(), "MenuItems");
		
		$this->assertEqual($this->menuItem->name(), "__25");
		$this->assertEqual($this->menuItem->parentId(), "__GUID");
		$this->assertEqual($this->menuItem->text(), "__50");
		$this->assertEqual($this->menuItem->tooltip(), "__50");
		$this->assertEqual($this->menuItem->url(), "__100");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->menuItem->className(), "MenuItem");
		$this->assertEqual($this->menuItem->collectionName(), "MenuItems");
		
		$this->assertEqual($this->menuItem->name(), "");
		$this->assertEqual($this->menuItem->parentId(), "");
		$this->assertEqual($this->menuItem->text(), "");
		$this->assertEqual($this->menuItem->tooltip(), "");
		$this->assertEqual($this->menuItem->url(), "");
	}
	
	function test_constructor_shouldCreateCustomInstance()
	{
		$menuItem = new MenuItem("parent", "http://www.foobar.com", "Foo Bar", "Go to Foo Bar");
		
		$this->assertEqual($menuItem->name(), "");
		$this->assertEqual($menuItem->parentId(), "parent");
		$this->assertEqual($menuItem->text(), "Foo Bar");
		$this->assertEqual($menuItem->tooltip(), "Go to Foo Bar");
		$this->assertEqual($menuItem->url(), "http://www.foobar.com");
	}
			
	function test_constructor_shouldRegisterListsAndFunctions()
	{
		$lists = $this->menuItem->lists();
		
		$this->assertEqual(sizeof($lists), 1);
		
		$list = $lists["children"];
		
		$this->assertEqual($list->name(), "children");
		$this->assertEqual($list->itemClass(), "MenuItem");
		$this->assertEqual($list->isSynced(), true);
		$this->assertEqual($list->sortRule(), null);
		
		$functions = $this->menuItem->ajaxFunctions();
		
		$this->assertEqual(sizeof($functions), 1);
		
		$function = $functions[0];
		
		$this->assertEqual($function->name(), "addMenuItem");
		$this->assertEqual($function->parameters(), array("url", "text", "tooltip", "name"));
		$this->assertEqual($function->isStatic(), false);
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->menuItem->url("foo");
		$this->menuItem->text("bar");
		$this->menuItem->tooltip("foo bar");
		$this->menuItem->name("foobar");
		$this->menuItem->save();
		
		$tmpObj = new MenuItem();
		$tmpObj->load($this->menuItem->id());
		
		$this->assertEqual($tmpObj->url(), "foo");
		$this->assertTrue($tmpObj->text(), "bar");
		$this->assertTrue($tmpObj->tooltip(), "foo bar");
		$this->assertEqual($tmpObj->name(), "foobar");
		
		
		$this->assertEqual($tmpObj->name(""), "");
	}
	
    
	
	function test_addMenuItem_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("id_required"));
		$this->menuItem->addMenuItem("Foo bar", "");
	}

	function test_addMenuItem_shouldFailForMissingText()
	{
		$this->menuItem->save();
		
		$this->expectException(new Exception("text_required"));
		$this->menuItem->addMenuItem("", "");
	}

	function test_addThread_shouldAddMultipleMenuItems()
	{
		$this->menuItem->save();
		
		$this->assertTrue($this->menuItem->addMenuItem("http://www.saidi.se", "saidi.se"));
		$this->assertTrue($this->menuItem->addMenuItem("http://www.wigbi.com", "wigbi.com", "Go to wigbi.com", "wigbi-link"));

		$items = $this->menuItem->getListItems("children");		
		$items = $items[0];
		$item1 = $items[0];
		$item2 = $items[1];
		
		$this->assertEqual(sizeof($items), 2);
		
		$this->assertEqual($item1->url(), "http://www.saidi.se");
		$this->assertEqual($item1->text(), "saidi.se");
		$this->assertEqual($item1->tooltip(), "");
		$this->assertEqual($item1->name(), "");
		
		$this->assertEqual($item2->url(), "http://www.wigbi.com");
		$this->assertEqual($item2->text(), "wigbi.com");
		$this->assertEqual($item2->tooltip(), "Go to wigbi.com");
		$this->assertEqual($item2->name(), "wigbi-link");
	}
    
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->menuItem->text("       ");
		
		$this->assertEqual($this->menuItem->validate(), array("text_required"));
		
		$this->menuItem->text("foo bar");
		
		$this->assertEqual($this->menuItem->validate(), array());
	}
}

?>