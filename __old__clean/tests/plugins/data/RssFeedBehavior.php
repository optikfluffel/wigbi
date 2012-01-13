<?php

class RssFeedBehavior extends UnitTestCase
{
	private $rssFeed;
	private $item;
	

	
	function RssFeedBehavior()
	{
		$this->UnitTestCase("RssFeed data plugin");
	}
	
	function setUp()
	{
		$this->rssFeed = new RssFeed();
		$this->item = new RssFeedItem();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->rssFeed = new RssFeed();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->rssFeed->className(), "RssFeed");
		$this->assertEqual($this->rssFeed->collectionName(), "RssFeeds");
		
		$this->assertEqual($this->rssFeed->title(), "__50");
		$this->assertEqual($this->rssFeed->link(), "__100");
		$this->assertEqual($this->rssFeed->description(), "__500");
		$this->assertEqual($this->rssFeed->category(), "__50");
		$this->assertEqual($this->rssFeed->copyright(), "__50");
		$this->assertEqual($this->rssFeed->ttl(), 60);
		$this->assertEqual($this->rssFeed->imageUrl(), "__100");
		$this->assertEqual($this->rssFeed->createdDateTime(), "__DATETIME");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->rssFeed->className(), "RssFeed");
		$this->assertEqual($this->rssFeed->collectionName(), "RssFeeds");
		
		$this->assertEqual($this->rssFeed->title(), "");
		$this->assertEqual($this->rssFeed->link(), "");
		$this->assertEqual($this->rssFeed->description(), "");
		$this->assertEqual($this->rssFeed->category(), "");
		$this->assertEqual($this->rssFeed->copyright(), "");
		$this->assertEqual($this->rssFeed->ttl(), 60);
		$this->assertEqual($this->rssFeed->imageUrl(), "");
		$this->assertEqual($this->rssFeed->createdDateTime(), "");
	}
			
	function test_constructor_shouldRegisterLists()
	{
		$lists = $this->rssFeed->lists();
		$this->assertEqual(sizeof($lists), 1);
		
		$list = $lists["items"];
		$this->assertEqual($list->name(), "items");
		$this->assertEqual($list->itemClass(), "RssFeedItem");
		$this->assertEqual($list->isSynced(), true);
		$this->assertEqual($list->sortRule(), "createdDateTime DESC");
	}
	
	function test_properties_shouldBePersisted()
	{
		$this->rssFeed->title("Title");
		$this->rssFeed->link("http://www.rss.com");
		$this->rssFeed->description("An RSS 2.0 feed");
		$this->rssFeed->category("The category");
		$this->rssFeed->copyright("The copyright");
		$this->rssFeed->ttl(40);
		$this->rssFeed->imageUrl("The URL");
		$this->rssFeed->save();
		
		$tmpObj = new RssFeed();
		$tmpObj->load($this->rssFeed->id());
		
		$this->assertEqual($tmpObj->title(), "Title");
		$this->assertEqual($tmpObj->link(), "http://www.rss.com");
		$this->assertEqual($tmpObj->description(), "An RSS 2.0 feed");
		$this->assertEqual($tmpObj->category(), "The category");
		$this->assertEqual($tmpObj->copyright(), "The copyright");
		$this->assertEqual($tmpObj->ttl(), 40);
		$this->assertEqual($tmpObj->imageUrl(), "The URL");
		$this->assertTrue($tmpObj->createdDateTime());
	}
	

	function test_toXml_shouldCreateValidXml()
	{
		$this->rssFeed->title("Title");
		$this->rssFeed->link("http://www.rss.com");
		$this->rssFeed->description("An RSS 2.0 feed");
		$this->rssFeed->category("The category");
		$this->rssFeed->copyright("The copyright");
		$this->rssFeed->ttl(40);
		$this->rssFeed->imageUrl("The URL");
		$this->rssFeed->save();
		
		$item = new RssFeedItem();
		$item->title("Title");
		$item->description("Description");
		$item->save();
		$this->rssFeed->addListItem("items", $item->id());
		
		$string = $this->rssFeed->toXml(2);
		$xml = @"<?xml version=\"1.0\"?>
<rss version=\"2.0\">
<channel>
	<title>" . $this->rssFeed->title() . "</title>
	<link>" . $this->rssFeed->link() . "</link>
	<description>" . $this->rssFeed->description() . "</description>
	<category>" . $this->rssFeed->category() . "</category>
	<copyright>" . $this->rssFeed->copyright() . "</copyright>
	<ttl>" . $this->rssFeed->ttl() . "</ttl>
	
	<image>
		<url>" . $this->rssFeed->imageUrl() . "</url>
		<title>" . $this->rssFeed->title() . "</title>
		<link>" . $this->rssFeed->link() . "</link>
	</image>
	
	" . $item->toXml() . "
	
	<guid>" . $this->rssFeed->id() . "</guid>
	<pubDate>" . date("D, d M Y, H:i:s", strtotime($this->rssFeed->createdDateTime())) . " GMT</pubDate>
</channel>";
		
		$this->assertEqual($string, $xml);
	}
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->rssFeed->title("       ");
		$this->rssFeed->description("       ");
		
		$this->assertEqual($this->rssFeed->validate(), array("title_required", "description_required"));
		
		$this->rssFeed->title("Title");
		
		$this->assertEqual($this->rssFeed->validate(), array("description_required"));
		
		$this->rssFeed->description("Description");
		
		$this->assertEqual($this->rssFeed->validate(), array());
	}
}

?>