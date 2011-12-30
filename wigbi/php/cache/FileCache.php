<?php

/**
 * The Wigbi FileCache class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi FileCache class.
 * 
 * This class can be used to cache data to the file system. It can
 * handle all kind of serializable data.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Cache
 * @version			2.0.0
 */
class FileCache extends CacheBase implements ICache
{
	/**
	 * @param	string	$cacheFolder	The path to the cache folder.
	 */
	public function __construct($cacheFolder)
	{
		$this->_cacheFolder = $cacheFolder;
	}
	
	
	/**
	 * The path to the folder in which cache files will be stored.
	 * 
	 * @return	string
	 */
	public function cacheFolder()
	{
		return $this->_cacheFolder;
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
		
	}
	
	/**
	 * Get the file path for a certain cache key. 
	 * 
	 * @param	string	$key	The cache key.
	 * @return	string			The path to the cache file.
	 */
	public function getFilePath($key)
	{
		return $this->cacheFolder() . "/cache_" . $key;
	}
	
	/**
	 * Cache any serializable data to the file system. 
	 * 
	 * @param	string	$key		The cache key to set.
	 * @param	mixed	$data		The data that is to be cached.
	 * @param	int		$expires	The expiration time, in minutes.
	 * @return	bool				Whether or not the operation succeeded.
	 */
	public function set($key, $data, $expires = 10)
	{
		
	}
}

?>