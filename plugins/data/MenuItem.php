<?php
/**
 * Wigbi.Plugins.Data.MenuItem class file.
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
 * The Wigbi.Plugins.Data.MenuItem class.
 * 
 * This class represents a menu item that can be used to link to any
 * internal or external URL.
 * 
 * A menu item can either be a root menu item without a parent, or a
 * child that belong to another menu item. Sub menu items are stored
 * in synced data lists.
 * 
 * Data lists:
 * 	<ul>
 * 		<li>subMenuItems (MenuItem) - synced</li>
 * 	</ul>
 * 
 * AJAX functionality:
 * 	<ul>
 * 		<li>public static void addMenuItem(string url, string text, string tooltip, string name, function onAddMenuItem(bool success))</li>
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
class MenuItem extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_parentId = "__GUID";
	public $_url = "__100";
	public $_text = "__50";
	public $_tooltip = "__50";
	public $_name = "__25";
	/**#@-*/
	
	
	public function __construct($parentId = null, $url = null, $text = null, $tooltip = null)
	{
		parent::__construct();
		
		if (func_num_args() > 0)
		{
			$this->parentId($parentId);
			$this->url($url);
			$this->text($text);
			$this->tooltip($tooltip);
		}
		
		$this->registerList("children", "MenuItem", true, null);
		$this->registerAjaxFunction("addMenuItem", array("url", "text", "tooltip", "name"), false);
	}
	
	
	public function name($value = null) { return $this->getSet("_name", $value); }
	public function parentId($value = null) { return $this->getSet("_parentId", $value); }
	public function text($value = null) { return $this->getSet("_text", $value); }
	public function tooltip($value = null) { return $this->getSet("_tooltip", $value); }
	public function url($value = null) { return $this->getSet("_url", $value); }
	

	/**
	 * Add an item to the menu item's sub menu.
	 * 
	 * @access	public
	 * 
	 * @param		string	$url			The url that the menu item links to.
	 * @param		string	$text			The text of the menu item.
	 * @param		string	$tooltip	The text that is displayed when the link is hovered; default blank.
	 * @param		string	$name			The optional name of the menu item; default blank.
	 * @return	bool							Whether or not the operation succeeded.
	 */
	public function addMenuItem($url, $text, $tooltip = "", $name = "")
	{
		//Abort if the object has not been saved
		if (!$this->id())
			throw new Exception("id_required");
			
		//Create new object
		$item = new MenuItem();
		$item->parentId($this->id());
		$item->url($url);
		$item->text($text);
		$item->tooltip($tooltip);
		$item->name($name);
			
		//Abort if the object is invalid
		$validationResult = $item->validate();
		if (sizeof($validationResult) > 0)
			throw new Exception(implode($validationResult, ","));
			
		//Save the object and add it to the list
		$item->save();
		$this->addListItem("children", $item->id());
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
		
		if (!trim($this->text()))
			array_push($errorList, "text_required");
			
		return $errorList;
	}
}
?>