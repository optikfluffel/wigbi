<?php

/**
 * The Wigbi MemoryCache class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi MemoryCache class.
 * 
 * This class can be used to cache data in memory. It supports all
 * kind of serializable data.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Cache
 * @version			2.0.0
 */
class MemoryCache extends CacheBase implements ICache
{
	private $_cache;
	
	
	public function __construct()
	{
		$this->_cache = array();
	}
	
	
	/**
	 * Retrieve data from the cache.
	 * 
	 * @param	string	$key		The cache key to get.
	 * @param	mixed	$fallback	Fallback value, if any.
	 * @return	mixed				Cached data or fallback value.
	 */
	public function get($key, $fallback = null)
	{
		if (!array_key_exists($key, $this->_cache))
			return $fallback;
		
		$data = $this->_cache[$key];
		$item = $this->parseCacheData($data);
		
		if (!$item->expired())
			return $item->data();
		
		unset($this->_cache[$key]);
		return $fallback;
	}
	
	/**
	 * Cache any serializable data to the file system. 
	 * 
	 * @param	string	$key		The cache key to set.
	 * @param	mixed	$data		The data that is to be cached.
	 * @param	int		$minutes	The expiration time, in minutes.
	 */
	public function set($key, $data, $minutes = 10)
	{
		$data = $this->createCacheData($data, $minutes);
		
		$this->_cache[$key] = $data;
	}
}

?>