<?php

/**
 * The Wigbi IGetContext interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IGetContext interface.
 * 
 * This interface can be implemented by any class that can be used
 * to retrieve contextual data by key.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Web
 * @version			2.0.0
 */
interface IGetContext
{
	/**
	 * Retrieve a certain context key.
	 * 
	 * @param	string	$key		The context key name.
	 * @param	mixed	$fallback	The value to return if the context key does not exist.
	 * @return	mixed
	 */
	function get($key, $fallback = null);
}

?>