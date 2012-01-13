<?php

class PodcastItemBehavior extends UnitTestCase
{
	private $podcastItem;
	

	
	function PodcastItemBehavior()
	{
		$this->UnitTestCase("PodcastItem data plugin");
	}
	
	function setUp()
	{
		$this->podcastItem = new PodcastItem();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->podcastItem = new PodcastItem();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->podcastItem->className(), "PodcastItem");
		$this->assertEqual($this->podcastItem->collectionName(), "PodcastItems");
		
		$this->assertEqual($this->podcastItem->title(), "__50");
		$this->assertEqual($this->podcastItem->link(), "__100");
		$this->assertEqual($this->podcastItem->description(), "__500");
		$this->assertEqual($this->podcastItem->duration(), "__10");
		$this->assertEqual($this->podcastItem->author(), "__50");
		$this->assertEqual($this->podcastItem->category(), "__50");
		$this->assertEqual($this->podcastItem->source(), "__50");
		$this->assertEqual($this->podcastItem->createdDateTime(), "__DATETIME");
		$this->assertEqual($this->podcastItem->podcastId(), "__GUID");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->podcastItem->className(), "PodcastItem");
		$this->assertEqual($this->podcastItem->collectionName(), "PodcastItems");
		
		$this->assertEqual($this->podcastItem->title(), "");
		$this->assertEqual($this->podcastItem->link(), "");
		$this->assertEqual($this->podcastItem->description(), "");
		$this->assertEqual($this->podcastItem->duration(), "");
		$this->assertEqual($this->podcastItem->author(), "");
		$this->assertEqual($this->podcastItem->category(), "");
		$this->assertEqual($this->podcastItem->source(), "");
		$this->assertEqual($this->podcastItem->createdDateTime(), "");
		$this->assertEqual($this->podcastItem->podcastId(), "");
	}
			
	
	
	function test_properties_shouldBePersisted()
	{
		$this->podcastItem->title("Title");
		$this->podcastItem->link("http://www.rss.com");
		$this->podcastItem->description("An RSS 2.0 feed item");
		$this->podcastItem->duration("121");
		$this->podcastItem->author("The author");
		$this->podcastItem->category("The category");
		$this->podcastItem->source("The source");
		$this->podcastItem->podcastId("id");
		$this->podcastItem->save();
		
		$tmpObj = new PodcastItem();
		$tmpObj->load($this->podcastItem->id());
		
		$this->assertEqual($tmpObj->title(), "Title");
		$this->assertEqual($tmpObj->link(), "http://www.rss.com");
		$this->assertEqual($tmpObj->description(), "An RSS 2.0 feed item");
		$this->assertEqual($tmpObj->duration(), "121");
		$this->assertEqual($tmpObj->author(), "The author");
		$this->assertEqual($tmpObj->category(), "The category");
		$this->assertEqual($tmpObj->source(), "The source");
		$this->assertTrue($tmpObj->createdDateTime());
		$this->assertEqual($tmpObj->podcastId(), "id");
	}
	

	function test_toXml_shouldCreateValidXml()
	{
		$this->podcastItem->title("Title");
		$this->podcastItem->link("http://www.rss.com");
		$this->podcastItem->description("An RSS 2.0 feed item");
		$this->podcastItem->duration("121");
		$this->podcastItem->author("The author");
		$this->podcastItem->category("The category");
		$this->podcastItem->source("The source");
		$this->podcastItem->podcastId("id");
		$this->podcastItem->save();
		
		$string = $this->podcastItem->toXml();
		$xml = @"<item>
	<title>" . $this->podcastItem->title() . "</title>
	<link>" . $this->podcastItem->link() . "</link>
	<description>" . $this->podcastItem->description() . "</description>
	<duration>" . $this->podcastItem->duration() . "</duration>
	<author>" . $this->podcastItem->author() . "</author>
	<category>" . $this->podcastItem->category() . "</category>
	<source>" . $this->podcastItem->source() . "</source>
	<guid>" . $this->podcastItem->id() . "</guid>
	<pubDate>" . date("D, d M Y, H:i:s", strtotime($this->podcastItem->createdDateTime())) . " GMT</pubDate>
</item>";
		
		$this->assertEqual($string, $xml);
	}
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->podcastItem->title("       ");
		$this->podcastItem->description("       ");
		
		$this->assertEqual($this->podcastItem->validate(), array("title_required", "description_required"));
		
		$this->podcastItem->title("Title");
		
		$this->assertEqual($this->podcastItem->validate(), array("description_required"));
		
		$this->podcastItem->description("Description");
		
		$this->assertEqual($this->podcastItem->validate(), array());
	}
}

?>