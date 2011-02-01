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
 * two objects.
 * 
 * If messages are sent between two objects, it may be convenient to
 * add the message to an inbox for the recipient and also add a copy
 * to an outbox for the recipient. This way, each object has its own
 * copy of the message.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */
class Message extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_senderId = "__GUID";
	public $_receiverId = "__GUID";
	public $_subject = "__50";
	public $_text = "__TEXT";
	public $_isRead = false;
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function isRead($value = null) { return $this->getSet("_isRead", $value); }
	public function receiverId($value = null) { return $this->getSet("_receiverId", $value); }
	public function senderId($value = null) { return $this->getSet("_senderId", $value); }
	public function subject($value = null) { return $this->getSet("_subject", $value); }
	public function text($value = null) { return $this->getSet("_text", $value); }
	
	
	public function validate()
	{
		$errorList = array();
		
		if (!trim($this->subject()))
			array_push($errorList, "subject_required");
		if (!trim($this->text()))
			array_push($errorList, "text_required");

		return $errorList;
	}
}
?>