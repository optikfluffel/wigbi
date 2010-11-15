<?php

class PodcastBehavior extends UnitTestCase
{
	private $podcast;
	private $item;
	
	
	
	function PodcastBehavior()
	{
		$this->UnitTestCase("Podcast data plugin");
	}
	
	function setUp()
	{
		$this->podcast = new Podcast();
		$this->item = new PodcastItem();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->podcast->setupDatabase();
		$this->item->setupDatabase();
	}
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->podcast = new Podcast();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->podcast->className(), "Podcast");
		$this->assertEqual($this->podcast->collectionName(), "Podcasts");
		
		$this->assertEqual($this->podcast->title(), "__50");
		$this->assertEqual($this->podcast->link(), "__100");
		$this->assertEqual($this->podcast->description(), "__500");
		$this->assertEqual($this->podcast->category(), "__50");
		$this->assertEqual($this->podcast->author(), "__50");
		$this->assertEqual($this->podcast->copyright(), "__50");
		$this->assertEqual($this->podcast->ttl(), 60);
		$this->assertEqual($this->podcast->smallImageUrl(), "__100");
		$this->assertEqual($this->podcast->largeImageUrl(), "__100");
		$this->assertEqual($this->podcast->explicit(), false);
		$this->assertEqual($this->podcast->createdDateTime(), "__DATETIME");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->podcast->className(), "Podcast");
		$this->assertEqual($this->podcast->collectionName(), "Podcasts");
		
		$this->assertEqual($this->podcast->title(), "");
		$this->assertEqual($this->podcast->link(), "");
		$this->assertEqual($this->podcast->description(), "");
		$this->assertEqual($this->podcast->category(), "");
		$this->assertEqual($this->podcast->author(), "");
		$this->assertEqual($this->podcast->copyright(), "");
		$this->assertEqual($this->podcast->ttl(), 60);
		$this->assertEqual($this->podcast->smallImageUrl(), "");
		$this->assertEqual($this->podcast->largeImageUrl(), "");
		$this->assertEqual($this->podcast->explicit(), false);
		$this->assertEqual($this->podcast->createdDateTime(), "");
	}
			
	function test_constructor_shouldRegisterLists()
	{
		$lists = $this->podcast->lists();
		$this->assertEqual(sizeof($lists), 1);
		
		$list = $lists["items"];
		$this->assertEqual($list->name(), "items");
		$this->assertEqual($list->itemClass(), "PodcastItem");
		$this->assertEqual($list->isSynced(), true);
		$this->assertEqual($list->sortRule(), "createdDateTime DESC");
	}
	
	function test_properties_shouldBePersisted()
	{
		$this->podcast->title("Title");
		$this->podcast->link("http://www.rss.com");
		$this->podcast->description("An RSS 2.0 feed");
		$this->podcast->category("The category");
		$this->podcast->author("The author");
		$this->podcast->copyright("The copyright");
		$this->podcast->ttl(40);
		$this->podcast->smallImageUrl("The small URL");
		$this->podcast->largeImageUrl("The large URL");
		$this->podcast->explicit(false);
		$this->podcast->save();
		
		$tmpObj = new Podcast();
		$tmpObj->load($this->podcast->id());
		
		$this->assertEqual($tmpObj->title(), "Title");
		$this->assertEqual($tmpObj->link(), "http://www.rss.com");
		$this->assertEqual($tmpObj->description(), "An RSS 2.0 feed");
		$this->assertEqual($tmpObj->category(), "The category");
		$this->assertEqual($tmpObj->author(), "The author");
		$this->assertEqual($tmpObj->copyright(), "The copyright");
		$this->assertEqual($tmpObj->ttl(), 40);
		$this->assertEqual($tmpObj->smallImageUrl(), "The small URL");
		$this->assertEqual($tmpObj->largeImageUrl(), "The large URL");
		$this->assertEqual($tmpObj->explicit(), false);
		$this->assertTrue($tmpObj->createdDateTime());
	}
	

	function test_toXml_shouldCreateValidXml()
	{
		$this->podcast->title("Title");
		$this->podcast->link("http://www.rss.com");
		$this->podcast->description("An RSS 2.0 feed");
		$this->podcast->category("The category");
		$this->podcast->author("The author");
		$this->podcast->copyright("The copyright");
		$this->podcast->ttl(40);
		$this->podcast->smallImageUrl("The small URL");
		$this->podcast->largeImageUrl("The large URL");
		$this->podcast->explicit(true);
		$this->podcast->save();
		
		$item = new PodcastItem();
		$item->title("Title");
		$item->description("Description");
		$item->save();
		$this->podcast->addListItem("items", $item->id());
		
		$string = $this->podcast->toXml(2);
		$xml = @"<?xml version=\"1.0\"?>
<rss version=\"2.0\">
<channel>
	<title>" . $this->podcast->title() . "</title>
	<link>" . $this->podcast->link() . "</link>
	<description>" . $this->podcast->description() . "</description>
	<category>" . $this->podcast->category() . "</category>
	<author>" . $this->podcast->author() . "</author>
	<copyright>" . $this->podcast->copyright() . "</copyright>
	<ttl>" . $this->podcast->ttl() . "</ttl>
	
	<image>
		<url>" . $this->podcast->smallImageUrl() . "</url>
		<title>" . $this->podcast->title() . "</title>
		<link>" . $this->podcast->link() . "</link>
	</image>
	
	" . $item->toXml() . "
	
	<itunes:explicit>" . $this->podcast->explicit() . "</itunes:explicit>
	<itunes:author>" . $this->podcast->author() . "</itunes:author>
	<itunes:category text=\"" . $this->podcast->category() . "\" />
	<itunes:explicit>" . $this->podcast->explicit() . "</itunes:explicit>
	<itunes:image href=\"" . $this->podcast->largeImageUrl() . "\" />
	<itunes:link rel=\"image\" type=\"video/jpeg\" href=\"" . $this->podcast->largeImageUrl() . "\">" . $this->podcast->title() . "</itunes:link>
	<itunes:subititle>" . $this->podcast->title() . "</itunes:subititle>
	<itunes:summary>" . $this->podcast->description() . "</itunes:summary>

	<itunes:image>
		<url>" . $this->podcast->largeImageUrl() . "</url>
		<title>" . $this->podcast->title() . "</title>
		<link>" . $this->podcast->link() . "</link>
	</itunes:image>
	
	<guid>" . $this->podcast->id() . "</guid>
	<pubDate>" . date("D, d M Y, H:i:s", strtotime($this->podcast->createdDateTime())) . " GMT</pubDate>
</channel>";
		
		$this->assertEqual($string, $xml);
	}
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->podcast->title("       ");
		$this->podcast->description("       ");
		
		$this->assertEqual($this->podcast->validate(), array("titleRequired", "descriptionRequired"));
		
		$this->podcast->title("Title");
		
		$this->assertEqual($this->podcast->validate(), array("descriptionRequired"));
		
		$this->podcast->description("Description");
		
		$this->assertEqual($this->podcast->validate(), array());
	}
}

?>