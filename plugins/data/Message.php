<?php
/**
 * Wigbi.Plugins.Data.Message class file.
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
 * The Wigbi.Plugins.Data.Message class.
 * 
 * This class represents a general message, that can be sent between
 * two objects, which will probably be users. However, the class can
 * be used for any kind of objects.
 * 
 * The easiest way to connect a message to another Wigbi data plugin
 * class is to add a synced data list to the data plugin and add the
 * message to that list. This makes sure that the message is deleted
 * together with the object to which it belongs.
 * 
 * Since messages will most probably be between objects, it may be a
 * good idea to add it to an "inbox" for the receiver object and add
 * a copy to an "outbox" for the sender object. By doing so, the two
 * objects have a copy each. If one message is deleted, the other is
 * still available to its owner.
 * 
 * The senderId and receiverId properties can also be used as object
 * reference to provide fully traceable messages.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class Message extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_senderId = "__GUID";
	public $_receiverId = "__GUID";
	public $_createdDateTime = "__DATETIME";
	public $_subject = "__50";
	public $_text = "__TEXT";
	public $_isRead = false;
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function createdDateTime()
	{
		return $this->_createdDateTime;
	}
	
	public function isRead($value = true)
	{
		if (func_num_args() != 0)
			$this->_isRead = func_get_arg(0);
		return $this->_isRead;
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

	public function subject($value = "")
	{
		if (func_num_args() != 0)
			$this->_subject = func_get_arg(0);
		return $this->_subject;
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
		
		//Require that a subject and a text is defined
		if (!trim($this->subject()))
			array_push($errorList, "subjectRequired");
		if (!trim($this->text()))
			array_push($errorList, "textRequired");
			
		//Return error list
		return $errorList;
	}
}
?>