<?php

/**
 * The Wigbi JavaScriptFileIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi JavaScriptFileIncluder class.
 * 
 * This class can be used to include JavaScript files, by adding a
 * separate script tag for each file.
 * 
 * The class will automatically prefix local paths with the client
 * root, so it expects all local paths to application relative. If
 * a path is absolute (begins with an /) or global (http or https),
 * the class will include it as is.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
class JavaScriptFileIncluder implements IJavaScriptFileIncluder
{	
	/**
	 * Chech whether or not a path is application relative. 
	 * 
	 * @return 	bool
	 */
	public function isApplicationRelative($path)
	{
		$protocol = strstr($path, "://", true);
		if (strlen($protocol) > 0)
			return false;
		
		if (substr($path, 0, 1) == "/")
			return false;
		
		if (substr($path, 0, 3) == "../")
			return false;
		
		return true;
	}
	
	/**
	 * Include a certain file or folder.
	 */
	public function includeFile($path)
	{
		//<script type="text/javascript" src="../wigbi/bundle/js:wigbi/js/core,wigbi/js,wigbi/plugins/data,wigbi/plugins/ui,js"></script>
	}
}

?>