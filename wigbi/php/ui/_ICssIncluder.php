<?php

/**
 * The Wigbi ICssIncluder interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ICssIncluder interface.
 * 
 * This interface can be implemented by any class that can be used
 * to include CSS files as well as entire folders.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
interface ICssIncluder
{
	/**
	 * Include a certain file.
	 */
	function includeFile($path);
}

?>