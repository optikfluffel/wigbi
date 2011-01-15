<?php
/**
 * Wigbi.Plugins.Data.RssFeed class file.
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
 * The Wigbi.Plugins.Data.RssFeed class.
 * 
 * This class represents a general RSS 2.0 feed, to which feed items
 * can be added
 * 
 * Note that this class only specifies the most basic elements of an
 * RSS 2.0 feed. Further elements can be added manually.
 * 
 * 
 * DATA LISTS ********************
 * 
 * The class has the following data lists: 
 * 
 * 	<ul>
 * 		<li>items (RssFeedItem) - synced</li>
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
class RssFeed extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_title = "__50";
	public $_link = "__100";
	public $_description = "__500";
	public $_category = "__50";
	public $_copyright = "__50";
	public $_ttl = 60;
	public $_imageUrl = "__100";
	
	public $_createdDateTime = "__DATETIME";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->registerList("items", "RssFeedItem", true, "createdDateTime DESC");
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

	public function imageUrl($value = "")
	{
		if (func_num_args() != 0)
			$this->_imageUrl = func_get_arg(0);
		return $this->_imageUrl;
	}

	public function link($value = "")
	{
		if (func_num_args() != 0)
			$this->_link = func_get_arg(0);
		return $this->_link;
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
	 * Serialize the RSS feed into a valid XML string.
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
	<copyright>" . $this->copyright() . "</copyright>
	<ttl>" . $this->ttl() . "</ttl>
	
	<image>
		<url>" . $this->imageUrl() . "</url>
		<title>" . $this->title() . "</title>
		<link>" . $this->link() . "</link>
	</image>
	
	<items />
	
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