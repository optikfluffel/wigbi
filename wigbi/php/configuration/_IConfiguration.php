<?php

/**
 * The Wigbi IConfiguration interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IConfiguration interface.
 * 
 * This interface can be implemented by any class that can be used
 * as a configuration handler.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Configuration
 * @version			2.0.0
 */
interface IConfiguration
{
	/**
	 * Get a certain configuration key value.
	 * 
	 * @param	string	$key		The configuration key to retrieve.
	 * @param	string	$section	The configuration section, if any.
	 * @return	string
	 */
	function get($key, $section = "");
}

?>