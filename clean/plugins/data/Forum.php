<?php
/**
 * Wigbi.Plugins.Data.Forum class file.
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
 * The Wigbi.Plugins.Data.Forum class.
 * 
 * This class represents a general forum to which forum threads can
 * be added. The threads can then be populated with forum posts.
 * 
 * Data lists:
 * 	<ul>
 * 		<li>threads (ForumThread) - synced</li>
 * 	</ul>
 * 
 * AJAX functionality:
 * 	<ul>
 * 		<li>public void addThread(string name, string description, string createdById, function onAddThread(bool result))</li>
 * 	</ul>
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */
class Forum extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_createdById = "__GUID";
	public $_name = "__50";
	public $_description = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->registerList("threads", "ForumThread", true, "createdDateTime DESC");
		
		$this->registerAjaxFunction("addThread", array("name", "description", "createdById"), false);
	}
	
	
	public function createdById($value = null) { return $this->getSet("_createdById", $value); }
	public function description($value = null) { return $this->getSet("_description", $value); }
	public function name($value = null) { return $this->getSet("_name", $value); }
	
	
	/**
	 * Add a thread to the forum.
	 * 
	 * @access	public
	 * 
	 * @param	string	$name					The name of the thread.
	 * @param	string	$description	The thread description; default blank.
	 * @param	string	$createdById	The ID of the creator; default blank.
	 * @return	bool								Whether or not the operation succeeded.
	 */
	public function addThread($name, $description = "", $createdById = "")
	{
		//Abort if the object has not been saved
		if (!$this->id())
			throw new Exception("id_required");
			
		//Create new thread
		$thread = new ForumThread();
		$thread->forumId($this->id());
		$thread->name($name);
		$thread->description($description);
		$thread->createdById($createdById);
			
		//Abort if the post is invalid
		$validationResult = $thread->validate();
		if (sizeof($validationResult) > 0)
			throw new Exception(implode($validationResult, ","));
			
		//Save the post and add it to the list
		$thread->save();
		$this->addListItem("threads", $thread->id());
		return true;
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
		
		if (!trim($this->name()))
			array_push($errorList, "name_required");

		return $errorList;
	}
}
?>