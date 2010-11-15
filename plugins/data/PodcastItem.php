<?php
/**
 * Wigbi.Plugins.Data.PodcastItem class file.
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
 * The Wigbi.Plugins.Data.PodcastItem class.
 * 
 * This class represents a general podcast item that can be added to
 * any podcast feed. It will most probably be used together with the
 * Podcast data plugin class and kept in the synced "items" list. 
 * 
 * The podcastId property can also be used as an object reference to
 * provide fully traceable podcast items.
 * 
 * Note that this class only specifies the most basic elements for a
 * podcast item. Further elements can be added manually.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class PodcastItem extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_title = "__50";
	public $_link = "__100";
	public $_description = "__500";
	public $_duration = "__10";
	public $_author = "__50";
	public $_category = "__50";
	public $_source = "__50";
	
	public $_createdDateTime = "__DATETIME";
	public $_podcastId = "__GUID";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
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

	public function duration($value = "")
	{
		if (func_num_args() != 0)
			$this->_duration = func_get_arg(0);
		return $this->_duration;
	}

	public function link($value = "")
	{
		if (func_num_args() != 0)
			$this->_link = func_get_arg(0);
		return $this->_link;
	}

	public function podcastId($value = "")
	{
		if (func_num_args() != 0)
			$this->_podcastId = func_get_arg(0);
		return $this->_podcastId;
	}

	public function source($value = "")
	{
		if (func_num_args() != 0)
			$this->_source = func_get_arg(0);
		return $this->_source;
	}

	public function title($value = "")
	{
		if (func_num_args() != 0)
			$this->_title = func_get_arg(0);
		return $this->_title;
	}
	
	
	/**
	 * Serialize the odcast item into a valid XML string.
	 * 
	 * @access	public
	 * 
	 * @return	string	Valid RSS 2.0 item XML string.
	 */
	public function toXml()
	{
		return @"<item>
	<title>" . $this->title() . "</title>
	<link>" . $this->link() . "</link>
	<description>" . $this->description() . "</description>
	<duration>" . $this->duration() . "</duration>
	<author>" . $this->author() . "</author>
	<category>" . $this->category() . "</category>
	<source>" . $this->source() . "</source>
	<guid>" . $this->id() . "</guid>
	<pubDate>" . date("D, d M Y, H:i:s", strtotime($this->createdDateTime())) . " GMT</pubDate>
</item>";
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
			array_push($errorList, "titleRequired");
		if (!trim($this->description()))
			array_push($errorList, "descriptionRequired");
			
		//Return error list
		return $errorList;
	}
}
?>