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
	 * @param	string	$key	The cache key to clear.
	 */
	public function clear($key)
	{
		$this->set($key, null, -10);
	}
	
	/**
	 * Create a serialized cache data string that can be cached.
	 * 
	 * @param	mixed	$data		The data to embed.
	 * @param	int		$minutes	The expiration time, in minutes.
	 * @return	string				The resulting cache data.
	 */
	public function createCacheData($data, $minutes)
	{
		$item = new CacheItem($data, $this->createTimeStamp($minutes));
		
		return serialize($item);
	}
	
	/**
	 * Create a time stamp string to be appended to the cached data.
	 * 
	 * @param	int		$minutes	The expiration time, in minutes.
	 * @return	string				The resulting time stamp string.
	 */
	public function createTimeStamp($minutes)
	{
		return mktime(date("H"), date("i") + $minutes, date("s"), date("m"), date("d"), date("Y"));
	}
	
	/**
	 * Parse a serialized cache string to a corresponding cache item.
	 * 
	 * @param	string		$data	The serialized data to parse.
	 * @return	CacheItem			The resulting, parsed cache item.
	 */
	public function parseCacheData($data)
	{
		return unserialize($data);
	}
}

?>