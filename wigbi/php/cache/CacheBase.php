<?php

/**
 * The Wigbi CacheBase class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi CacheBase class.
 * 
 * This class provides base functionality for the cache classes in
 * this package.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Cache
 * @version			2.0.0
 */
class CacheBase
{
	/**
	 * Clear a certain cache key.
	 * 
	 * @param	string	$key	The cache key.
	 * @return	bool			Whether or not the operation succeeded.
	 */
	function clear($key)
	{
		$this->set($key, null, 0);
		return $this->get($key) == null;
	}
	
	/**
	 * Create a time stamp string to be appended to the cached data.
	 * 
	 * @param	int		$expires	The expiration time, in minutes.
	 * @return	string				The resulting time stamp string.
	 */
	public function createTimeStamp($expires)
	{
		return date("YmdHis", mktime(date("H"), date("i") + $expires, date("s"), date("m"), date("d"), date("Y")));
	}
	
	/**
	 * Parse a time stamp string and retrieve the remaining minutes.
	 * 
	 * @param	string	$timeStamp	The time stamp string to parse.
	 * @return	time				The resulting time stamp, false if parsing failed.
	 */
	public function parseTimeStamp($timeStamp)
	{
		return strtotime($timeStamp);
	}
}

?>