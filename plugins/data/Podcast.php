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
 * Note that this class specifies basic podcast feed elements. It is
 * possible to add further elements manually.
 * 
 * 
 * DATA LISTS ********************
 * 
 * The class has the following data lists: 
 * 
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
 * @version			1.0.0
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
	
	public $_createdDateTime = "__DATETIME";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->registerList("items", "PodcastItem", true, "createdDateTime DESC");
	}
	
	
	public function author($value = "")
	{
		if (func_num_args() != 0)
			$this->_author = func_get_arg(0);
		return $this->_author;
	}
	
	public function category($value = "")
	{
		if (func_num_args() != 0)
			$this->_category = func_get_arg(0);
		return $this->_category;
	}
	
	public function copyright($value = "")
	{
		if (func_num_args() != 0)
			$this->_copyright = func_get_arg(0);
		return $this->_copyright;
	}
	
	public function createdDateTime()
	{
		return $this->_createdDateTime;
	}

	public function description($value = "")
	{
		if (func_num_args() != 0)
			$this->_description = func_get_arg(0);
		return $this->_description;
	}

	public function explicit($value = false)
	{
		if (func_num_args() != 0)
			$this->_explicit = func_get_arg(0);
		return $this->_explicit;
	}
	
	public function largeImageUrl($value = "")
	{
		if (func_num_args() != 0)
			$this->_largeImageUrl = func_get_arg(0);
		return $this->_largeImageUrl;
	}

	public function link($value = "")
	{
		if (func_num_args() != 0)
			$this->_link = func_get_arg(0);
		return $this->_link;
	}

	public function smallImageUrl($value = "")
	{
		if (func_num_args() != 0)
			$this->_smallImageUrl = func_get_arg(0);
		return $this->_smallImageUrl;
	}
	
	public function title($value = "")
	{
		if (func_num_args() != 0)
			$this->_title = func_get_arg(0);
		return $this->_title;
	}

	public function ttl($value = 60)
	{
		if (func_num_args() != 0)
			$this->_ttl = func_get_arg(0);
		return $this->_ttl;
	}
	
	
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
	<pubDate>" . date("D, d M Y, H:i:s", strtotime($this->createdDateTime())) . " GMT</pubDate>
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
		//Init error list
		$errorList = array();
		
		//Require a title and a description
		if (!trim($this->title()))
			array_push($errorList, "title_required");
		if (!trim($this->description()))
			array_push($errorList, "description_required");
			
		//Return error list
		return $errorList;
	}
}
?>