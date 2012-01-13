<?php
/**
 * Wigbi.Plugins.Data.Podcast class file.
 * 
 * Wigbi is free software. You can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *  
 * Wigbi is distributed in the hope that it will be useful, but WITH
 * NO WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public
 * License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with Wigbi. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The Wigbi.Plugins.Data.Podcast class.
 * 
 * This class represents a podcast feed, to which podcast feed items
 * can be added.
 * 
 * Data lists:
 * 	<ul>
 * 		<li>items (PodcastItem) - synced</li>
 * 	</ul>
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */
class Podcast extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_title = "__50";
	public $_link = "__100";
	public $_description = "__500";
	public $_category = "__50";
	public $_author = "__50";
	public $_copyright = "__50";
	public $_ttl = 60;
	public $_smallImageUrl = "__100";
	public $_largeImageUrl = "__100";
	public $_explicit = false;
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->registerList("items", "PodcastItem", true, "createdDateTime DESC");
	}
	
	
	public function author($value = null) { return $this->getSet("_author", $value); }
	public function category($value = null) { return $this->getSet("_category", $value); }
	public function copyright($value = null) { return $this->getSet("_copyright", $value); }
	public function description($value = null) { return $this->getSet("_description", $value); }
	public function explicit($value = null) { return $this->getSet("_explicit", $value); }
	public function largeImageUrl($value = null) { return $this->getSet("_largeImageUrl", $value); }
	public function link($value = null) { return $this->getSet("_link", $value); }
	public function smallImageUrl($value = null) { return $this->getSet("_smallImageUrl", $value); }
	public function title($value = null) { return $this->getSet("_title", $value); }
	public function ttl($value = null) { return $this->getSet("_ttl", $value); }
	
	
	/**
	 * Serialize the feed into a valid XML string.
	 * 
	 * @access	public
	 * 
	 * @param	string	$maxCount	The max number of items to display.
	 * @return	string				Valid RSS 2.0 XML string.
	 */
	public function toXml($maxCount = 10)
	{
		$xml = @"<?xml version=\"1.0\"?>
<rss version=\"2.0\">
<channel>
	<title>" . $this->title() . "</title>
	<link>" . $this->link() . "</link>
	<description>" . $this->description() . "</description>
	<category>" . $this->category() . "</category>
	<author>" . $this->author() . "</author>
	<copyright>" . $this->copyright() . "</copyright>
	<ttl>" . $this->ttl() . "</ttl>
	
	<image>
		<url>" . $this->smallImageUrl() . "</url>
		<title>" . $this->title() . "</title>
		<link>" . $this->link() . "</link>
	</image>
	
	<items />
	
	<itunes:explicit>" . $this->explicit() . "</itunes:explicit>
	<itunes:author>" . $this->author() . "</itunes:author>
	<itunes:category text=\"" . $this->category() . "\" />
	<itunes:explicit>" . $this->explicit() . "</itunes:explicit>
	<itunes:image href=\"" . $this->largeImageUrl() . "\" />
	<itunes:link rel=\"image\" type=\"video/jpeg\" href=\"" . $this->largeImageUrl() . "\">" . $this->title() . "</itunes:link>
	<itunes:subititle>" . $this->title() . "</itunes:subititle>
	<itunes:summary>" . $this->description() . "</itunes:summary>

	<itunes:image>
		<url>" . $this->largeImageUrl() . "</url>
		<title>" . $this->title() . "</title>
		<link>" . $this->link() . "</link>
	</itunes:image>
	
	<guid>" . $this->id() . "</guid>
	<pubDate>" . date("D, d M Y, H:i:s", strtotime($this->lastUpdatedDateTime())) . " GMT</pubDate>
</channel>";
		
		$items = $this->getListItems("items", 0, $maxCount);
		$items = $items[0];
		$itemString = "";
		foreach ($items as $item)
			$itemString .= $item->toXml();
					
		$result = str_replace("<items />", $itemString, $xml);
		return $result;
	}
	
	/**
	 * Validate the object.
	 * 
	 * @access	public
	 * 
	 * @return	array	Error list; empty if valid.
	 */
	public function validate()
	{
		$errorList = array();
		
		if (!trim($this->title()))
			array_push($errorList, "title_required");
		if (!trim($this->description()))
			array_push($errorList, "description_required");
			
		return $errorList;
	}
}
?>