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
	private $_cacheFolder;
	private $_directoryHandler;
	private $_fileHandler;
	
	
	/**
	 * @param	string			$cacheFolder		The path to the cache folder.
	 * @param	IFileHandler	$directoryHandler	The IDirectoryHandler implementation to use for file operations.
	 * @param	IFileHandler	$fileHandler		The IFileHandler implementation to use for file operations.
	 */
	public function __construct($cacheFolder, $directoryHandler, $fileHandler)
	{
		$this->_cacheFolder = $cacheFolder;
		$this->_directoryHandler = $directoryHandler;
		$this->_fileHandler = $fileHandler;
	}
	
	
	/**
	 * Retrieve data from the cache.
	 * 
	 * @param	string	$key		The cache key to get.
	 * @param	mixed	$fallback	The value to return if no cached value exists.
	 * @return	mixed				Cached data or fallback value.
	 */
	public function get($key, $fallback = null)
	{
		$path = $this->getFilePath($key);
		
		if (!$this->_fileHandler->exists($path))
			return $fallback;
		
		$data = $this->_fileHandler->read($path);
		$item = $this->parseCacheData($data);
		
		if (!$item->expired())
			return $item->data();
		
		$this->_fileHandler->delete($path);
		return $fallback;
	}
	
	/**
	 * Get the file path for a certain cache key. 
	 * 
	 * @param	string	$key	The cache key.
	 * @return	string			The path to the cache file.
	 */
	public function getFilePath($key)
	{
		return $this->_cacheFolder . "/cache_" . $key;
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
		if (!$this->_directoryHandler->exists($this->_cacheFolder))
			 $this->_directoryHandler->create($this->_cacheFolder);
	
		$path = $this->getFilePath($key);
		$data = $this->createCacheData($data, $minutes);
		
		$this->_fileHandler->write($path, "w", $data);
	}
}

?>