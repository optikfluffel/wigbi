<?php

class RssFeedItemBehavior extends UnitTestCase
{
	private $rssFeedItem;
	
	
	
	function RssFeedItemBehavior()
	{
		$this->UnitTestCase("RssFeedItem data plugin");
	}
	
	function setUp()
	{
		$this->rssFeedItem = new RssFeedItem();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->rssFeedItem->setupDatabase();
	}
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->rssFeedItem = new RssFeedItem();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->rssFeedItem->className(), "RssFeedItem");
		$this->assertEqual($this->rssFeedItem->collectionName(), "RssFeedItems");
		
		$this->assertEqual($this->rssFeedItem->title(), "__50");
		$this->assertEqual($this->rssFeedItem->link(), "__100");
		$this->assertEqual($this->rssFeedItem->description(), "__500");
		$this->assertEqual($this->rssFeedItem->author(), "__50");
		$this->assertEqual($this->rssFeedItem->category(), "__50");
		$this->assertEqual($this->rssFeedItem->source(), "__50");
		$this->assertEqual($this->rssFeedItem->createdDateTime(), "__DATETIME");
		$this->assertEqual($this->rssFeedItem->rssFeedId(), "__GUID");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->rssFeedItem->className(), "RssFeedItem");
		$this->assertEqual($this->rssFeedItem->collectionName(), "RssFeedItems");
		
		$this->assertEqual($this->rssFeedItem->title(), "");
		$this->assertEqual($this->rssFeedItem->link(), "");
		$this->assertEqual($this->rssFeedItem->description(), "");
		$this->assertEqual($this->rssFeedItem->author(), "");
		$this->assertEqual($this->rssFeedItem->category(), "");
		$this->assertEqual($this->rssFeedItem->source(), "");
		$this->assertEqual($this->rssFeedItem->createdDateTime(), "");
		$this->assertEqual($this->rssFeedItem->rssFeedId(), "");
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->rssFeedItem->title("Title");
		$this->rssFeedItem->link("http://www.rss.com");
		$this->rssFeedItem->description("An RSS 2.0 feed item");
		$this->rssFeedItem->author("The author");
		$this->rssFeedItem->category("The category");
		$this->rssFeedItem->source("The source");
		$this->rssFeedItem->rssFeedId("id");
		$this->rssFeedItem->save();
		
		$tmpObj = new RssFeedItem();
		$tmpObj->load($this->rssFeedItem->id());
		
		$this->assertEqual($tmpObj->title(), "Title");
		$this->assertEqual($tmpObj->link(), "http://www.rss.com");
		$this->assertEqual($tmpObj->description(), "An RSS 2.0 feed item");
		$this->assertEqual($tmpObj->author(), "The author");
		$this->assertEqual($tmpObj->category(), "The category");
		$this->assertEqual($tmpObj->source(), "The source");
		$this->assertTrue($tmpObj->createdDateTime());
		$this->assertEqual($tmpObj->rssFeedId(), "id");
	}
	

	function test_toXml_shouldCreateValidXml()
	{
		$this->rssFeedItem->title("Title");
		$this->rssFeedItem->link("http://www.rss.com");
		$this->rssFeedItem->description("An RSS 2.0 feed item");
		$this->rssFeedItem->author("The author");
		$this->rssFeedItem->category("The category");
		$this->rssFeedItem->source("The source");
		$this->rssFeedItem->rssFeedId("id");
		$this->rssFeedItem->save();
		
		$string = $this->rssFeedItem->toXml();
		$xml = @"<item>
	<title>" . $this->rssFeedItem->title() . "</title>
	<link>" . $this->rssFeedItem->link() . "</link>
	<description>" . $this->rssFeedItem->description() . "</description>
	<author>" . $this->rssFeedItem->author() . "</author>
	<category>" . $this->rssFeedItem->category() . "</category>
	<source>" . $this->rssFeedItem->source() . "</source>
	<guid>" . $this->rssFeedItem->id() . "</guid>
	<pubDate>" . date("D, d M Y, H:i:s", strtotime($this->rssFeedItem->createdDateTime())) . " GMT</pubDate>
</item>";
		
		$this->assertEqual($string, $xml);
	}
    
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->rssFeedItem->title("       ");
		$this->rssFeedItem->description("       ");
		
		$this->assertEqual($this->rssFeedItem->validate(), array("title_required", "description_required"));
		
		$this->rssFeedItem->title("Title");
		
		$this->assertEqual($this->rssFeedItem->validate(), array("description_required"));
		
		$this->rssFeedItem->description("Description");
		
		$this->assertEqual($this->rssFeedItem->validate(), array());
	}
}

?>