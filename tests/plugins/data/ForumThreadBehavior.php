<?php

class ForumThreadBehavior extends UnitTestCase
{
	private $forumThread;
	private $forumPost;
	

	
	function ForumThreadBehavior()
	{
		$this->UnitTestCase("ForumThread data plugin");
	}
	
	function setUp()
	{
		$this->forumThread = new ForumThread();
		$this->forumPost = new ForumPost();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->forumThread->setupDatabase();
		$this->forumPost->setupDatabase();
	}	
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->forumThread = new ForumThread();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->forumThread->className(), "ForumThread");
		$this->assertEqual($this->forumThread->collectionName(), "ForumThreads");
		
		$this->assertEqual($this->forumThread->createdById(), "__GUID");
		$this->assertEqual($this->forumThread->createdDateTime(), "__DATETIME");
		$this->assertEqual($this->forumThread->lastUpdatedDateTime(), "__DATETIME");
		$this->assertEqual($this->forumThread->forumId(), "__GUID");
		$this->assertEqual($this->forumThread->name(), "__50");
		$this->assertEqual($this->forumThread->description(), "__TEXT");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->forumThread->className(), "ForumThread");
		$this->assertEqual($this->forumThread->collectionName(), "ForumThreads");
		
		$this->assertEqual($this->forumThread->createdById(), "");
		$this->assertEqual($this->forumThread->createdDateTime(), "");
		$this->assertEqual($this->forumThread->lastUpdatedDateTime(), "");
		$this->assertEqual($this->forumThread->forumId(), "");
		$this->assertEqual($this->forumThread->name(), "");
		$this->assertEqual($this->forumThread->description(), "");
	}
			
	function test_constructor_shouldRegisterLists()
	{
		$lists = $this->forumThread->lists();
		
		$this->assertEqual(sizeof($lists), 1);
		
		$list = $lists["posts"];
		
		$this->assertEqual($list->name(), "posts");
		$this->assertEqual($list->itemClass(), "ForumPost");
		$this->assertEqual($list->isSynced(), true);
		$this->assertEqual($list->sortRule(), "createdDateTime");
		
		$functions = $this->forumThread->ajaxFunctions();
		
		$this->assertEqual(sizeof($functions), 1);
		
		$function = $functions[0];
		
		$this->assertEqual($function->name(), "addPost");
		$this->assertEqual($function->parameters(), array("content", "createdById"));
		$this->assertEqual($function->isStatic(), false);
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->forumThread->createdById("created by");
		$this->forumThread->forumId("forum");
		$this->forumThread->name("name");
		$this->forumThread->description("description");
		$this->forumThread->save();
		
		$tmpObj = new ForumThread();
		$tmpObj->load($this->forumThread->id());
		
		$this->assertEqual($tmpObj->createdById(), "created by");
		$this->assertEqual($tmpObj->forumId(), "forum");
		$this->assertTrue($tmpObj->createdDateTime());
		$this->assertTrue($tmpObj->lastUpdatedDateTime());
		$this->assertEqual($tmpObj->name(), "name");
		$this->assertEqual($tmpObj->description(), "description");
	}
	
    
	
	function test_addPost_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("id_required"));
		$this->forumThread->addPost("Foo bar", "");
	}

	function test_addPost_shouldFailForMissingContent()
	{
		$this->forumThread->save();
		
		$this->expectException(new Exception("content_required"));
		$this->forumThread->addPost("", "");
	}

	function test_addPost_shouldAddPost()
	{
		$this->forumThread->save();
		
		$result = $this->forumThread->addPost("Foo bar", "creator");
		$posts = $this->forumThread->getListItems("posts");
		$posts = $posts[0];
		$post = $posts[0];
		
		$this->assertTrue($result);
		$this->assertEqual(sizeof($posts), 1);
		$this->assertEqual($post->content(), "Foo bar");
		$this->assertEqual($post->createdById(), "creator");
	}
    
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->forumThread->name("       ");
		
		$this->assertEqual($this->forumThread->validate(), array("name_required"));
		
		$this->forumThread->name("foo bar");
		
		$this->assertEqual($this->forumThread->validate(), array());
	}
}

?>