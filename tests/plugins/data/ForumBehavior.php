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
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->forum->setupDatabase();
		$this->forumThread->setupDatabase();
		$this->forumPost->setupDatabase();
	}
	
	
	
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
		
		$this->assertEqual(sizeof($lists), 2);
		
		$list = $lists["posts"];
		
		$this->assertEqual($list->name(), "posts");
		$this->assertEqual($list->itemClass(), "ForumPost");
		$this->assertEqual($list->isSynced(), true);
		$this->assertEqual($list->sortRule(), "createdDateTime");
		
		$list = $lists["threads"];
		
		$this->assertEqual($list->name(), "threads");
		$this->assertEqual($list->itemClass(), "ForumThread");
		$this->assertEqual($list->isSynced(), true);
		$this->assertEqual($list->sortRule(), "createdDateTime DESC");
		
		$functions = $this->forum->ajaxFunctions();
		
		$this->assertEqual(sizeof($functions), 2);
		
		$function = $functions[0];
		
		$this->assertEqual($function->name(), "addPost");
		$this->assertEqual($function->parameters(), array("content", "createdById"));
		$this->assertEqual($function->isStatic(), false);
		
		$function = $functions[1];
		
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
	
    
	
	function test_addPost_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("idRequired"));
		$this->forum->addPost("Foo bar", "");
	}

	function test_addPost_shouldFailForMissingContent()
	{
		$this->forum->save();
		
		$this->expectException(new Exception("contentRequired"));
		$this->forum->addPost("", "");
	}

	function test_addPost_shouldAddMultiplePosts()
	{
		$this->forum->save();
		
		$result = $this->forum->addPost("Foo bar", "");
		$posts = $this->forum->getListItems("posts");
		$posts = $posts[0];
		$post = $posts[0];
		
		$this->assertTrue($result);
		$this->assertEqual(sizeof($posts), 1);
		$this->assertEqual($post->content(), "Foo bar");
		$this->assertEqual($post->createdById(), "");
	}
    
	function test_addThread_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("idRequired"));
		$this->forum->addThread("Foo bar", "", "");
	}

	function test_addThread_shouldFailForMissingName()
	{
		$this->forum->save();
		
		$this->expectException(new Exception("nameRequired"));
		$this->forum->addThread("", "", "");
	}

	function test_addThread_shouldAddMultipleThreads()
	{
		$this->forum->save();
		
		$result = $this->forum->addThread("Foo bar", "", "");
		$threads = $this->forum->getListItems("threads");
		$threads = $threads[0];
		$thread = $threads[0];
		
		$this->assertTrue($result);
		$this->assertEqual(sizeof($threads), 1);
		$this->assertEqual($thread->name(), "Foo bar");
		$this->assertEqual($thread->description(), "");
		$this->assertEqual($thread->createdById(), "");
	}
    
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->forum->name("       ");
		
		$this->assertEqual($this->forum->validate(), array("nameRequired"));
		
		$this->forum->name("foo bar");
		
		$this->assertEqual($this->forum->validate(), array());
	}
}

?>