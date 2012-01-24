<?php

/**
 * The Wigbi IJavaScriptIncluder interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IJavaScriptIncluder interface.
 * 
 * This interface can be implemented by any class that can be used
 * to include JavaScript files .
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
interface IJavaScriptIncluder
{
	/**
	 * Include a certain path.
	 */
	function includePath($path);
}

?>