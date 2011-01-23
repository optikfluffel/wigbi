<?php
/**
 * Wigbi.Plugins.Data.News class file.
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
 * The Wigbi.Plugins.Data.News class.
 * 
 * This class represents a general news item, which simply is a date
 * marked text with an optional title.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.2
 */
class News extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_createdDateTime = "__DATETIME";
	public $_title = "__50";
	public $_introduction = "__200";
	public $_content = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		$this->collectionName("News");
		parent::__construct();
	}

	public function content($value = null) { return $this->getSet("_content", $value); }
	public function createdDateTime() { return $this->_createdDateTime; }
	public function introduction($value = null) { return $this->getSet("_introduction", $value); }
	public function title($value = null) { return $this->getSet("_title", $value); }
	
	
	public function validate()
	{
		$errorList = array();
		
		if (!trim($this->title()))
			array_push($errorList, "title_required");
			
		return $errorList;
	}
}
?>