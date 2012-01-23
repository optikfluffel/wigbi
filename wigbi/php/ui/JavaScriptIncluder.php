<?php

/**
 * The Wigbi JavaScriptIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi JavaScriptIncluder class.
 * 
 * This class can be used to include JavaScript files & folders by
 * adding a separate script tag for each file.
 * 
 * The class will automatically prefix local paths with the client
 * root, so always provide it with application relative paths. The
 * class leaves absolute (begin with /) and global (http, ftp etc)
 * paths as they are.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
class JavaScriptIncluder extends ClientPathIncluderBase implements IJavaScriptIncluder
{ 
	/**
	 * @param	IFileSystem		$fileSystem		The IFileSystem to use for file system operations.
	 */
	public function __construct($fileSystem)
	{
		parent::__construct($fileSystem, "js");
	}
	
	
	/**
	 * Include a certain file by outputting a script include tag.
	 */
	public function includeFile($path)
	{
		$path = $this->adjustPath($path);
		print "<script type=\"text/javascript\" src=\"$path\"></script>";
	}
}

?>