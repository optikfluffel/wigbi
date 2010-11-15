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
 * This class represents a general forum that can contain both forum
 * threads as well as forum posts.
 * 
 * The createdById property can be used as an object ID reference to
 * make a forum fully traceable even when it is not loaded through a
 * data list that belongs one if its owner objects.
 * 
 * 
 * DATA LISTS ********************
 * 
 * The class has the following data lists: 
 * 
 * 	<ul>
 * 		<li>posts (ForumPost) - synced</li>
 * 		<li>threads (ForumThread) - synced</li>
 * 	</ul>
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * The class has the following AJAX functions, besides the ones that
 * are provided by the WigbiDataPlugin JavaScript base class:
 * 
 * 	<ul>
 * 		<li>public void addPost(string content, string createdById, function onAddPost(bool result))</li>
 * 		<li>public void addThread(string name, string description, string createdById, function onAddThread(bool result))</li>
 * 	</ul>
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class Forum extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_createdById = "__GUID";
	public $_createdDateTime = "__DATETIME";
	public $_lastUpdatedDateTime = "__DATETIME";
	public $_name = "__50";
	public $_description = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->registerList("threads", "ForumThread", true, "createdDateTime DESC");
		$this->registerList("posts", "ForumPost", true, "createdDateTime");
		
		$this->registerAjaxFunction("addPost", array("content", "createdById"), false);
		$this->registerAjaxFunction("addThread", array("name", "description", "createdById"), false);
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

	
	public function description($value = "")
	{
		if (func_num_args() != 0)
			$this->_description = func_get_arg(0);
		return $this->_description;
	}
	
	public function lastUpdatedDateTime()
	{
		return $this->_lastUpdatedDateTime;
	}
	
	
	public function name($value = "")
	{
		if (func_num_args() != 0)
			$this->_name = func_get_arg(0);
		return $this->_name;
	}
	
	
	/**
	 * Add a post to the forum.
	 * 
	 * @access	public
	 * 
	 * @param	string	$content		The textual content of the post.
	 * @param	string	$createdById	The ID of the creator; default blank.
	 * @return	bool					Whether or not the operation succeeded.
	 */
	public function addPost($content, $createdById = "")
	{
		//Abort if the object has not been saved
		if (!$this->id())
			throw new Exception("idRequired");
			
		//Create new post
		$post = new ForumPost();
		$post->content($content);
		$post->forumThreadId($this->id());
		$post->createdById($createdById);
			
		//Abort if the post is invalid
		$validationResult = $post->validate();
		if (sizeof($validationResult) > 0)
			throw new Exception(implode($validationResult, ","));
			
		//Save the post and add it to the list
		$post->save();
		$this->addListItem("posts", $post->id());
		return true;
	}

	/**
	 * Add a thread to the forum.
	 * 
	 * @access	public
	 * 
	 * @param	string	$name			The name of the thread.
	 * @param	string	$description	The thread description; default blank.
	 * @param	string	$createdById	The ID of the creator; default blank.
	 * @return	bool					Whether or not the operation succeeded.
	 */
	public function addThread($name, $description = "", $createdById = "")
	{
		//Abort if the object has not been saved
		if (!$this->id())
			throw new Exception("idRequired");
			
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
		//Init error list
		$errorList = array();
		
		//Require that name is defined
		if (!trim($this->name()))
			array_push($errorList, "nameRequired");
			
		//Return error list
		return $errorList;
	}
}
?>