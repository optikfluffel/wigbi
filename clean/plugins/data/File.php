<?php
/**
 * Wigbi.Plugins.Data.File class file.
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
 * The Wigbi.Plugins.Data.File class.
 * 
 * This class represents a general file, with extended properties to
 * be able to specify name and description.
 * 
 * The file url is synced, which means that the file will be deleted
 * together with the object.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */
class File extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_fileUrl = "__FILE";
	public $_fileName = "__50";
	public $_description = "__100";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function description($value = null) { return $this->getSet("_description", $value); }
	public function fileName($value = null) { return $this->getSet("_fileName", $value); }
	public function fileUrl($value = null) { return $this->getSet("_fileUrl", $value); }
	
	
	public function validate()
	{
		$errorList = array();
		
		if (!trim($this->fileUrl()))
			array_push($errorList, "fileUrl_required");
			
		return $errorList;
	}
}
?>