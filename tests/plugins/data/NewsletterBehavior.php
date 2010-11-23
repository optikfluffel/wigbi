<?php

class NewsletterBehavior extends UnitTestCase
{
	private $newsletter;
	private $subscriber;
	

	
	function NewsletterBehavior()
	{
		$this->UnitTestCase("Newsletter data plugin");
	}
	
	function setUp()
	{
		$this->newsletter = new Newsletter();
		$this->subscriber = new NewsletterSubscriber();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->newsletter->setupDatabase();
		$this->subscriber->setupDatabase();
	}
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->newsletter = new Newsletter();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->newsletter->className(), "Newsletter");
		$this->assertEqual($this->newsletter->collectionName(), "Newsletters");
		
		$this->assertEqual($this->newsletter->name(), "Unnamed newsletter__50");
		$this->assertEqual($this->newsletter->fromEmail(), "__50");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->newsletter->className(), "Newsletter");
		$this->assertEqual($this->newsletter->collectionName(), "Newsletters");
		
		$this->assertEqual($this->newsletter->name(), "Unnamed newsletter");
		$this->assertEqual($this->newsletter->fromEmail(), "");
	}
	
	function test_constructor_shouldRegisterListsAndFunctions()
	{
		$lists = $this->newsletter->lists();
		$this->assertEqual(sizeof($lists), 1);
		
		$list = $lists["subscribers"];
		
		$this->assertEqual($list->name(), "subscribers");
		$this->assertEqual($list->itemClass(), "NewsletterSubscriber");
		$this->assertEqual($list->isSynced(), true);
		$this->assertEqual($list->sortRule(), "email");
		
		$functions = $this->newsletter->ajaxFunctions();
		
		$this->assertEqual(sizeof($functions), 3);
		
		$function = $functions[0];
		
		$this->assertEqual($function->name(), "addSubscriber");
		$this->assertEqual($function->parameters(), array("email"));
		$this->assertEqual($function->isStatic(), false);
		
		$function = $functions[1];
		
		$this->assertEqual($function->name(), "removeSubscriber");
		$this->assertEqual($function->parameters(), array("email"));
		$this->assertEqual($function->isStatic(), false);
		
		$function = $functions[2];
		
		$this->assertEqual($function->name(), "sendEmail");
		$this->assertEqual($function->parameters(), array("subject", "mailBody"));
		$this->assertEqual($function->isStatic(), false);
	}

    
		
	function test_properties_shouldBePersisted()
	{
		$this->newsletter->name("name");
		$this->newsletter->fromEmail("foo.bar@foobar.com");
		$this->newsletter->save();
		
		$tmpObj = new Newsletter();
		$tmpObj->load($this->newsletter->id());
		
		$this->assertEqual($tmpObj->name(), "name");
		$this->assertEqual($tmpObj->fromEmail(), "foo.bar@foobar.com");
	}
	
    
    
	function test_addSubscriber_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("id_required"));
		$this->newsletter->addSubscriber("foo@bar.com");
	}

	function test_addSubscriber_shouldFailForMissingEmailAddress()
	{
		$this->newsletter->save();
		
		$this->expectException(new Exception("email_required"));
		$this->newsletter->addSubscriber("");
	}

	function test_addSubscriber_shouldFailForInvalidEmailAddress()
	{
		$this->newsletter->save();
		
		$this->expectException(new Exception("email_invalid"));
		$this->newsletter->addSubscriber("foobar.com");
	}

	function test_addSubscriber_shouldAddUniqueSubscriberOnce()
	{
		$this->newsletter->save();
		
		$result = $this->newsletter->addSubscriber("foo@bar.com");
		$subscribers = $this->newsletter->getListItems("subscribers");
		$subscribers = $subscribers[0];
		$subscriber = $subscribers[0];
		
		$this->assertTrue($result);
		$this->assertEqual(sizeof($subscribers), 1);
		$this->assertEqual($subscriber->email(), "foo@bar.com");
		
		$result = $this->newsletter->addSubscriber("foo2@bar.com");
		$subscribers = $this->newsletter->getListItems("subscribers");
		$subscribers = $subscribers[0];
		$subscriber1 = $subscribers[0];
		$subscriber2 = $subscribers[1];
		
		$this->assertTrue($result);
		$this->assertEqual(sizeof($subscribers), 2);
		$this->assertEqual($subscriber1->email(), "foo@bar.com");
		$this->assertEqual($subscriber2->email(), "foo2@bar.com");
		
		$result = $this->newsletter->addSubscriber("foo@bar.com");
		$subscribers = $this->newsletter->getListItems("subscribers");
		$subscribers = $subscribers[0];
		$subscriber1 = $subscribers[0];
		$subscriber2 = $subscribers[1];
		
		$this->assertTrue($result);
		$this->assertEqual(sizeof($subscribers), 2);
		$this->assertEqual($subscriber1->email(), "foo@bar.com");
		$this->assertEqual($subscriber2->email(), "foo2@bar.com");
	}
	
	function test_removeSubscriber_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("id_required"));
		$this->newsletter->removeSubscriber("foo@bar.com");
	}

	function test_removeSubscriber_shouldFailForUnaddedSubscriber()
	{
		$this->newsletter->save();
		$result = $this->newsletter->removeSubscriber("");
		
		$this->assertFalse($result);
	}

	function test_removeSubscriber_shouldAddUniqueSubscriberOnce()
	{
		$this->newsletter->save();
		
		$result = $this->newsletter->addSubscriber("foo@bar.com");
		$result = $this->newsletter->addSubscriber("foo2@bar.com");
		$subscribers = $this->newsletter->getListItems("subscribers");
		$subscribers = $subscribers[0];
		
		$this->assertEqual(sizeof($subscribers), 2);
		
		$result = $this->newsletter->removeSubscriber("foo@bar.com");
		$subscribers = $this->newsletter->getListItems("subscribers");
		$subscribers = $subscribers[0];
		$subscriber = $subscribers[0];
		
		$this->assertEqual(sizeof($subscribers), 1);
		$this->assertEqual($subscriber->email(), "foo2@bar.com");
	}
	
	function test_sendEmail_shouldFailForMissingSubjectOrMailBody()
	{
		$this->expectException(new Exception("subject_required,mailBody_required"));
		$this->newsletter->sendEmail("", "");
		$this->expectException(new Exception("subject_required"));
		$this->newsletter->sendEmail("", "Content");
		$this->expectException(new Exception("mailBody_required"));
		$this->newsletter->sendEmail("Subject", "");
	}
	
	function test_sendEmail_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("id_required"));
		$this->newsletter->sendEmail("Subject", "Body");
	}

	function test_sendEmail_shouldFailForMissingFromEmail()
	{
		$this->newsletter->save();
		
		$this->expectException(new Exception("fromEmail_required"));
		$result = $this->newsletter->sendEmail("Subject", "Body");
	}

	function test_sendEmail_shouldFailForInvalidFromEmail()
	{
		$this->newsletter->fromEmail("foo");
		$this->newsletter->save();
		
		$this->expectException(new Exception("fromEmail_invalid"));
		$result = $this->newsletter->sendEmail("Subject", "Body");
	}

	function test_sendEmail_shouldFailForNoSubscribers()
	{
		$this->newsletter->fromEmail("foo@bar.com");
		$this->newsletter->save();
		
		$this->expectException(new Exception("noSubscribers"));
		$result = $this->newsletter->sendEmail("Subject", "Body");
	}

	function test_sendEmail_shouldSendEmailToSubscribers()
	{
		//TODO: How to test the system mail function?
	}
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->assertEqual($this->newsletter->validate(), array("fromEmail_required"));
		
		$this->newsletter->fromEmail("foo");
		
		$this->assertEqual($this->newsletter->validate(), array("fromEmail_invalid"));
		
		$this->newsletter->fromEmail("foo@bar.com");
		
		$this->assertEqual($this->newsletter->validate(), array());
	}
}

?>