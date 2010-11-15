<?php
/**
 * Wigbi.Plugins.Data.ForumPost class file.
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
 * The Wigbi.Plugins.Data.ForumPost class.
 * 
 * This class represents a general forum post, which can be added to
 * a forum or a forum thread.
 * 
 * The createdById, forumId and forumThreadId properties can be used
 * as object ID references to make a forum post fully traceable even
 * when it is retrieved without the data lists of its owner objects.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class ForumPost extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_createdById = "__GUID";
	public $_createdDateTime = "__DATETIME";
	public $_lastUpdatedDateTime = "__DATETIME";
	public $_forumThreadId = "__GUID";
	public $_content = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function content($value = "")
	{
		if (func_num_args() != 0)
			$this->_content = func_get_arg(0);
		return $this->_content;
	}

	public function createdById($value = "")
	{
		if (func_num_args() != 0)
			$this->_createdById = func_get_arg(0);
		return $this->_createdById;
	}
	
	public function createdDateTime()
	{
		return $this->_createdDateTime;
	}

	public function forumThreadId($value = "")
	{
		if (func_num_args() != 0)
			$this->_forumThreadId = func_get_arg(0);
		return $this->_forumThreadId;
	}
	
	public function lastUpdatedDateTime()
	{
		return $this->_lastUpdatedDateTime;
	}
	
	
	public function validate()
	{
		//Init error list
		$errorList = array();
		
		//Require that content is defined
		if (!trim($this->content()))
			array_push($errorList, "contentRequired");
			
		//Return error list
		return $errorList;
	}
}
?>