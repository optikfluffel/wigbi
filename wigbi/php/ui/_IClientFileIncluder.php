<?php

/**
 * The Wigbi IClientFileIncluder interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IClientFileIncluder interface.
 * 
 * This interface can be implemented by any class that can be used
 * to include client files to a page.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
interface IClientFileIncluder
{
	/**
	 * Include a certain file.
	 * 
	 * When using this method, use the full client url of the file.
	 * 
	 * @param	string	$filePath
	 */
	function includeFile($filePath);
	
	/**
	 * Include several files in a certain folder.
	 * 
	 * When using this method, only use the full client url to the
	 * folder, then use the relative paths for each file. The file
	 * paths must be provided as parameters.
	 * 
	 * @param	string	$folderPath
	 * @param	params	$filePaths
	 */
	function includeFiles($folderPath, $filePaths);
}

?>