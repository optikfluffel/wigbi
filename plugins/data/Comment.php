<?php
/**
 * Wigbi.Plugins.Data.Comment class file.
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
 * The Wigbi.Plugins.Data.Comment class.
 * 
 * This class represents a general comment that can be applied to an
 * object of any kind, even "non-existing", non-stored objects.
 * 
 * If the commented object is not stored in a database and therefore
 * has no ID, the ownerId property can be used as a unique name. For
 * instance, when a class is commented on the Wigbi demo site, a new
 * comment is created with ownerId set to the name of the class.
 * 
 * The easiest way to connect a comment to another Wigbi data plugin
 * class is to add a synced data list to the data plugin and add the
 * comment to that list. This makes sure that the comment is deleted
 * together with the object to which it belongs.
 * 
 * The senderId and receiverId properties can also be used as object
 * reference to provide fully traceable comments.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class Comment extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_authorName = "__50";
	public $_authorEmail = "__50";
	public $_authorUrl = "__50";
	public $_senderId = "__GUID";
	public $_receiverId = "__GUID";
	public $_createdDateTime = "__DATETIME";
	public $_text = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function authorEmail($value = "")
	{
		if (func_num_args() != 0)
			$this->_authorEmail = func_get_arg(0);
		return $this->_authorEmail;
	}

	public function authorName($value = "")
	{
		if (func_num_args() != 0)
			$this->_authorName = func_get_arg(0);
		return $this->_authorName;
	}

	public function authorUrl($value = "")
	{
		if (func_num_args() != 0)
			$this->_authorUrl = func_get_arg(0);
		return $this->_authorUrl;
	}

	public function createdDateTime()
	{
		return $this->_createdDateTime;
	}

	public function receiverId($value = "")
	{
		if (func_num_args() != 0)
			$this->_receiverId = func_get_arg(0);
		return $this->_receiverId;
	}

	public function senderId($value = "")
	{
		if (func_num_args() != 0)
			$this->_senderId = func_get_arg(0);
		return $this->_senderId;
	}

	public function text($value = "")
	{
		if (func_num_args() != 0)
			$this->_text = func_get_arg(0);
		return $this->_text;
	}
	
	
	public function validate()
	{
		//Init error list
		$errorList = array();
		
		//Require a valid e-mail address if one is defined
		if ($this->authorEmail() && !ValidationHandler::isEmail($this->authorEmail()))
			array_push($errorList, "emailInvalid");
		
		//Require that a text is defined
		if (!trim($this->text()))
			array_push($errorList, "textRequired");
			
		//Return error list
		return $errorList;
	}
}
?>