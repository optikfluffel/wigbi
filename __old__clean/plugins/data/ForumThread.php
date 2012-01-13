<?php
/**
 * Wigbi.Plugins.Data.ForumThread class file.
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
 * The Wigbi.Plugins.Data.ForumThread class.
 * 
 * This class represents a general forum thread that can be added to
 * a forum and contain forum posts.
 * 
 * Data lists:
 * 	<ul>
 * 		<li>posts (ForumPost) - synced</li>
 * 	</ul>
 * 
 * AJAX functionality:
 * 	<ul>
 * 		<li>public void addPost(string content, string createdById, function onAddPost(bool result))</li>
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
class ForumThread extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_createdById = "__GUID";
	public $_forumId = "__GUID";
	public $_name = "__50";
	public $_description = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->registerList("posts", "ForumPost", true, "createdDateTime");
		
		$this->registerAjaxFunction("addPost", array("content", "createdById"), false);
	}
	
	
	public function createdById($value = null) { return $this->getSet("_createdById", $value); }
	public function description($value = null) { return $this->getSet("_description", $value); }
	public function forumId($value = null) { return $this->getSet("_forumId", $value); }
	public function name($value = null) { return $this->getSet("_name", $value); }
	
	
	/**
	 * Add a post to the thread.
	 * 
	 * @access	public
	 * 
	 * @param	string	$content			The textual content of the post.
	 * @param	string	$createdById	The ID of the creator; default blank.
	 * @return	bool								Whether or not the operation succeeded.
	 */
	public function addPost($content, $createdById = "")
	{
		//Abort if the object has not been saved
		if (!$this->id())
			throw new Exception("id_required");
			
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