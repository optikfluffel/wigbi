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
 * This class represents a menu item that, for instance, can be used
 * within a web site menu.
 * 
 * It is also possible to add sub menu items to a menu item. The sub
 * menu items are stored in a synced data list.
 * 
 * Except the display text, url and tooltip text, a link can also be
 * given a name, which can be used to identify it. It can be freely. 
 * 
 * 
 * DATA LISTS ********************
 * 
 * The class has the following data lists: 
 * 
 * 	<ul>
 * 		<li>subMenuItems (MenuItem) - synced</li>
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
class MenuItem extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_parentId = "__GUID";
	public $_name = "__25";
	public $_linkText = "__50";
	public $_url = "__100";
	public $_tooltip = "__50";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->registerList("subMenu", "MenuItem", true, null);
	}
	
	
	public function linkText($value = "")
	{
		if (func_num_args() != 0)
			$this->_linkText = func_get_arg(0);
		return $this->_linkText;
	}
	
	public function name($value = "")
	{
		if (func_num_args() != 0)
			$this->_name = func_get_arg(0);
		return $this->_name;
	}
	
	public function parentId($value = "")
	{
		if (func_num_args() != 0)
			$this->_parentId = func_get_arg(0);
		return $this->_parentId;
	}
	
	public function tooltip($value = "")
	{
		if (func_num_args() != 0)
			$this->_tooltip = func_get_arg(0);
		return $this->_tooltip;
	}
	
	public function url($value = "")
	{
		if (func_num_args() != 0)
			$this->_url = func_get_arg(0);
		return $this->_url;
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
			
		//Return error list
		return $errorList;
	}
}
?>