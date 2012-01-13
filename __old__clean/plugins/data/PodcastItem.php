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
 * Podcast data plugin and kept in its synced "items" list.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
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
	public $_podcastId = "__GUID";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function author($value = null) { return $this->getSet("_author", $value); }
	public function category($value = null) { return $this->getSet("_category", $value); }
	public function description($value = null) { return $this->getSet("_description", $value); }
	public function duration($value = null) { return $this->getSet("_duration", $value); }
	public function link($value = null) { return $this->getSet("_link", $value); }
	public function podcastId($value = null) { return $this->getSet("_podcastId", $value); }
	public function source($value = null) { return $this->getSet("_source", $value); }
	public function title($value = null) { return $this->getSet("_title", $value); }
	
	
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
		$errorList = array();
		
		if (!trim($this->title()))
			array_push($errorList, "title_required");
		if (!trim($this->description()))
			array_push($errorList, "description_required");

		return $errorList;
	}
}
?>