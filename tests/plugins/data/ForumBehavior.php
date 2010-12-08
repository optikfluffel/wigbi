<?php

class ForumBehavior extends UnitTestCase
{
	private $forum;
	private $forumThread;
	private $forumPost;
	
	
	
	function ForumBehavior()
	{
		$this->UnitTestCase("Forum data plugin");
	}
	
	function setUp()
	{
		$this->forum = new Forum();
		$this->forumThread = new ForumThread();
		$this->forumPost = new ForumPost();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->forum = new Forum();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->forum->className(), "Forum");
		$this->assertEqual($this->forum->collectionName(), "Forums");
		
		$this->assertEqual($this->forum->createdById(), "__GUID");
		$this->assertEqual($this->forum->createdDateTime(), "__DATETIME");
		$this->assertEqual($this->forum->lastUpdatedDateTime(), "__DATETIME");
		$this->assertEqual($this->forum->name(), "__50");
		$this->assertEqual($this->forum->description(), "__TEXT");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->forum->className(), "Forum");
		$this->assertEqual($this->forum->collectionName(), "Forums");
		
		$this->assertEqual($this->forum->createdById(), "");
		$this->assertEqual($this->forum->createdDateTime(), "");
		$this->assertEqual($this->forum->lastUpdatedDateTime(), "");
		$this->assertEqual($this->forum->name(), "");
		$this->assertEqual($this->forum->description(), "");
	}
			
	function test_constructor_shouldRegisterListsAndFunctions()
	{
		$lists = $this->forum->lists();
		
		$this->assertEqual(sizeof($lists), 1);
		
		$list = $lists["threads"];
		
		$this->assertEqual($list->name(), "threads");
		$this->assertEqual($list->itemClass(), "ForumThread");
		$this->assertEqual($list->isSynced(), true);
		$this->assertEqual($list->sortRule(), "createdDateTime DESC");
		
		$functions = $this->forum->ajaxFunctions();
		
		$this->assertEqual(sizeof($functions), 1);
		
		$function = $functions[0];
		
		$this->assertEqual($function->name(), "addThread");
		$this->assertEqual($function->parameters(), array("name", "description", "createdById"));
		$this->assertEqual($function->isStatic(), false);
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->forum->createdById("created by");
		$this->forum->name("name");
		$this->forum->description("description");
		$this->forum->save();
		
		$tmpObj = new Forum();
		$tmpObj->load($this->forum->id());
		
		$this->assertEqual($tmpObj->createdById(), "created by");
		$this->assertTrue($tmpObj->createdDateTime());
		$this->assertTrue($tmpObj->lastUpdatedDateTime());
		$this->assertEqual($tmpObj->name(), "name");
		$this->assertEqual($tmpObj->description(), "description");
	}
	
    
	
	function test_addThread_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("id_required"));
		$this->forum->addThread("Foo bar", "", "");
	}

	function test_addThread_shouldFailForMissingName()
	{
		$this->forum->save();
		
		$this->expectException(new Exception("name_required"));
		$this->forum->addThread("", "", "");
	}

	function test_addThread_shouldAddMultipleThreads()
	{
		
		$this->forum->save();
		
		$this->assertTrue($this->forum->addThread("Foo"));
		$this->assertTrue($this->forum->addThread("Bar", "A bar related thread", "foo bar"));

		$items = $this->forum->getListItems("threads");		
		$items = $items[0];
		$item1 = $items[0];
		$item2 = $items[1];
		
		$this->assertEqual(sizeof($items), 2);
		
		$this->assertEqual($item1->name(), "Foo");
		$this->assertEqual($item1->description(), "");
		$this->assertEqual($item1->createdById(), "");
		
		$this->assertEqual($item2->name(), "Bar");
		$this->assertEqual($item2->description(), "A bar related thread");
		$this->assertEqual($item2->createdById(), "foo bar");
	}
    
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->forum->name("       ");
		
		$this->assertEqual($this->forum->validate(), array("name_required"));
		
		$this->forum->name("foo bar");
		
		$this->assertEqual($this->forum->validate(), array());
	}
}

?>