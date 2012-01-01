<?php

/**
 * The Wigbi ICache interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ICache interface.
 * 
 * This interface can be implemented by any class that can be used
 * to handle cached data.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Cache
 * @version			2.0.0
 */
interface ICache
{
	/**
	 * Clear a certain cache key.
	 * 
	 * @param	string	$key	The cache key.
	 */
	function clear($key);
	
	/**
	 * Retrieve data from the cache.
	 * 
	 * @param	string	$key		The cache key to retrieve.
	 * @param	mixed	$fallback	Fallback value, if any.
	 * @return	mixed				Cached data or fallback value.
	 */
	function get($key, $fallback = null);
	
	/**
	 * Cache any serializable data. 
	 * 
	 * @param	string	$key		The cache key.
	 * @param	mixed	$data		The data that is to be cached.
	 * @param	int		$minutes	The expiration time, in minutes.
	 */
	function set($key, $data, $minutes = 10);
}

?>