<?php
/**
 * Wigbi.Plugins.Data.ImageFile class file.
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
 * The Wigbi.Plugins.Data.ImageFile class.
 * 
 * This class represents a general image file with a set of extended
 * properties for name, description, dimensions, author etc.
 * 
 * The file url is synced, which means that the file that the object
 * points to will be deleted together with the object.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class ImageFile extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_fileUrl = "__FILE";
	public $_fileName = "__50";
	public $_description = "__100";
	public $_author = "__50";
	public $_width = 0;
	public $_height = 0;
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function author($value = "")
	{
		if (func_num_args() != 0)
			$this->_author = func_get_arg(0);
		return $this->_author;
	}
	
	public function description($value = "")
	{
		if (func_num_args() != 0)
			$this->_description = func_get_arg(0);
		return $this->_description;
	}
	
	public function fileName($value = "")
	{
		if (func_num_args() != 0)
			$this->_fileName = func_get_arg(0);
		return $this->_fileName;
	}
	
	public function fileUrl($value = "")
	{
		if (func_num_args() != 0)
			$this->_fileUrl = func_get_arg(0);
		return $this->_fileUrl;
	}
	
	public function height($value = "")
	{
		if (func_num_args() != 0)
			$this->_height = func_get_arg(0);
		return $this->_height;
	}
	
	public function width($value = "")
	{
		if (func_num_args() != 0)
			$this->_width = func_get_arg(0);
		return $this->_width;
	}
	
	
	public function validate()
	{
		//Init error list
		$errorList = array();
		
		//Require that a file URL is defined
		if (!trim($this->fileUrl()))
			array_push($errorList, "fileUrl_required");
			
		//Require positive width/height
		if ($this->width() < 0)
			array_push($errorList, "width_negative");
		if ($this->height() < 0)
			array_push($errorList, "height_negative");
			
		//Return error list
		return $errorList;
	}
}
?>