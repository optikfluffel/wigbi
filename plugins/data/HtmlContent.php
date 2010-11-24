<?php
/**
 * Wigbi.Plugins.Data.HtmlContent class file.
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
 * The Wigbi.Plugins.Data.HtmlContent class.
 * 
 * This class represents general HTML content that can be applied to
 * any part of a web page.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class HtmlContent extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_name = "__50";
	public $_title = "__25";
	public $_createdDateTime = "__DATETIME";
	public $_lastUpdatedDateTime = "__DATETIME";
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
	
	public function createdDateTime()
	{
		return $this->_createdDateTime;
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
		
		//Require that a name is defined
		if (!trim($this->name()))
			array_push($errorList, "name_required");
			
		//Return error list
		return $errorList;
	}
}
?>