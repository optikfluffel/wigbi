<?php

class NewsletterSubscriberBehavior extends UnitTestCase
{
	private $newsletterSubscriber;
	

	
	function NewsletterSubscriberBehavior()
	{
		$this->UnitTestCase("NewsletterSubscriber data plugin");
	}
	
	function setUp()
	{
		$this->newsletterSubscriber = new NewsletterSubscriber();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->newsletterSubscriber->setupDatabase();
	}
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->newsletterSubscriber = new NewsletterSubscriber();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->newsletterSubscriber->className(), "NewsletterSubscriber");
		$this->assertEqual($this->newsletterSubscriber->collectionName(), "NewsletterSubscribers");
		$this->assertEqual($this->newsletterSubscriber->email(), "__50");
		$this->assertEqual($this->newsletterSubscriber->newsletterId(), "__GUID");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->newsletterSubscriber->className(), "NewsletterSubscriber");
		$this->assertEqual($this->newsletterSubscriber->collectionName(), "NewsletterSubscribers");
		$this->assertEqual($this->newsletterSubscriber->email(), "");
		$this->assertEqual($this->newsletterSubscriber->newsletterId(), "");
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->newsletterSubscriber->email("email");
		$this->newsletterSubscriber->newsletterId("newsletter");
		$this->newsletterSubscriber->save();
		
		$tmpObj = new NewsletterSubscriber();
		$tmpObj->load($this->newsletterSubscriber->id());
		
		$this->assertEqual($tmpObj->email(), "email");
		$this->assertEqual($tmpObj->newsletterId(), "newsletter");
	}
	

    	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->newsletterSubscriber->email("       ");
		
		$this->assertEqual($this->newsletterSubscriber->validate(), array("emailRequired"));
		
		$this->newsletterSubscriber->email("foo bar");
		
		$this->assertEqual($this->newsletterSubscriber->validate(), array("emailInvalid"));
		
		$this->newsletterSubscriber->email("foo.bar@foobar.com");
		
		$this->assertEqual($this->newsletterSubscriber->validate(), array());
	}
}

?>