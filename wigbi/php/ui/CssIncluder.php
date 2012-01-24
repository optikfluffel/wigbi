<?php

/**
 * The Wigbi CssIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi CssIncluder class.
 * 
 * This class can be used to include CSS files & folders by adding
 * a separate link tag for each file.
 * 
 * Since the class performs file system operations for directories,
 * it requires that all local paths are application relative.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
class CssIncluder extends ClientPathIncluderBase implements ICssIncluder
{
	/**
	 * @param	IFileSystem		$fileSystem		The IFileSystem to use for file system operations.
	 */
	public function __construct($fileSystem)
	{
		parent::__construct($fileSystem, "css");
	}
	
	
	/**
	 * Include a certain file by outputting a script include tag.
	 */
	public function includeFile($path)
	{
		$path = Wigbi::clientRoot($path);
		print "<link rel=\"stylesheet\" type=\"text/css\" href=\"$path\" />";
	}
}

?>