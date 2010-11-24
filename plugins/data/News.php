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
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class News extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_createdDateTime = "__DATETIME";
	public $_content = "__TEXT";
	public $_title = "__50";
	/**#@-*/
	
	
	public function __construct()
	{
		$this->collectionName("News");
		parent::__construct();
	}
	
	
	public function content($value = "")
	{
		if (func_num_args() != 0)
			$this->_content = func_get_arg(0);
		return $this->_content;
	}
	
	public function createdDateTime()
	{
		return $this->_createdDateTime;
	}
	
	public function title($value = "")
	{
		if (func_num_args() != 0)
			$this->_title = func_get_arg(0);
		return $this->_title;
	}
	
	
	public function validate()
	{
		//Init error list
		$errorList = array();
		
		//Require that a title is defined
		if (!trim($this->title()))
			array_push($errorList, "title_required");
			
		//Return error list
		return $errorList;
	}
}
?>