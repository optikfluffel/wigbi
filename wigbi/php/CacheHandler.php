<?php

/**
 * Wigbi.PHP.CacheHandler class file.
 * 
 * Wigbi is free software. You can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *  
 * Wigbi is distributed in the hope that it will be useful, but WITH
 * NO WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public
 * License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with Wigbi. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The Wigbi.PHP.CacheHandler class.
 * 
 * This class can be used to save and retrieve cached data. It fully
 * supports all serializible data and can thus store complex objects
 * as well as simple strings, integers etc.
 * 
 * For caching to work, the cache folder must have write permissions
 * enabled. Otherwise, the operation will fail with an exception.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 */
class CacheHandler
{
	/**#@+
	 * @ignore
	 */
	private $_currentKey;
	private $_currentValidityTime;
	public $_cacheFolder;
	/**#@-*/

	
	
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	string	$cacheFolder	The path to the cache folder; default "cache".
	 */
	public function __construct($cacheFolder = "cache")
	{
		$this->_cacheFolder = $cacheFolder;
	}
	
	

	/**
	 * Get/set the path to the cache folder.
	 * 
	 * @access	public
	 * 
	 * @param		string	$value	Optional set value.
	 * @return	string					The path to the cache folder.
	 */
	public function cacheFolder($value = "")
	{
		if(func_num_args() != 0)
			$this->_cacheFolder = func_get_arg(0);
		return $this->_cacheFolder;
	}
	
	
	
	/**
	 * Begin caching the output buffer.
	 * 
	 * Use this function to begin caching everything that is sent
	 * to the output buffer. Use the endCaching method to stop.
	 * 
	 * @access	public
	 * 
	 * @param	string	$key					The cache data key name.
	 * @param	int			$validityTime	The time, in minutes, for how long the data is valid; default 10.
	 */
	public function beginCaching($key, $validityTime = 10)
	{
		$this->_currentKey = $key;
		$this->_currentValidityTime = $validityTime;
	
		ob_start();
	}
	
	/**
	 * Clear any cached data.
	 * 
	 * @access	public
	 * 
	 * @param		string	$key	The cache data key name.
	 * @return	bool					Whether or not the operation succeeded.
	 */
	public function clear($key)
	{
		$this->set($key, null, 0);
		return $this->get($key) == null;
	}
	
	/**
	 * Stop caching the output buffer and save content to file.
	 * 
	 * Use this function to stop caching everything that is sent
	 * to the output buffer and write the colected data to file.
	 * 
	 * @access	public
	 * 
	 * @param	bool	$serialize 	Whether or not to serialize the output buffer content; default true.
	 */	
	public function endCaching($serialize = true)
	{
	  //Get data from the output buffer
		$data = ob_get_clean();
		if ($serialize)
			$data = serialize($data);
	
		//Create cache folder if it does not exist
		if (!is_dir($this->cacheFolder()))
			mkdir($this->cacheFolder());
	
		//Build time/data file content
		$timeString = date("YmdHis", mktime(date("H"), date("i") + $this->_currentValidityTime, date("s"), date("m"), date("d"), date("Y")));
		$fileContent = json_encode(array($timeString, $data));
		
		//Create and write content to file  
		$file = fopen($this->getFileName($this->_currentKey), "w") or die ("Error opening cache file");
			fwrite($file, $fileContent);
		fclose($file);
	}

	/**
	 * Retrieve cached data from file. 
	 * 
	 * @access	public
	 * 
	 * @param		string	$key	The cache data key name.
	 * @return	mixed					The cached data.
	 */
	public function get($key)
	{
		//Abort if the file does not exist
		if (!file_exists($this->getFileName($key)))
			return null;
	
		//Open and read file content, then convert to data
		$fileData = json_decode(file_get_contents($this->getFileName($key)));
		$fileTime = strtotime($fileData[0]);
	
		//Delete file and abort if it is too old
		if (time() > $fileTime)
		{
			unlink($this->getFileName($key));
			return null;
		}
	
		//Return file content
		return unserialize($fileData[1]);
	}
	
	/**
	 * Get the file name for a certain cache data key name. 
	 * 
	 * @access	private
	 * 
	 * @param		string	$key	The cache data key name.
	 * @return	string				The cache file name.
	 */
	private function getFileName($key)
	{
		return $this->cacheFolder() . "/cache_" . $key;
	}
	
	/**
	 * Cache any serializable data.
	 * 
	 * This function takes any serializable data and writes it to
	 * a cache file that is created in the defined cache folder. 
	 * 
	 * @access	public
	 * 
	 * @param	string	$key					The cache data key name.
	 * @param	mixed		$data					The data that is to be cached.
	 * @param	int			$validityTime	The time, in minutes, for how long the data is valid; default 10.
	 */
	public function set($key, $data, $validityTime = 10)
	{	
		$this->beginCaching($key, $validityTime);
		echo serialize($data);
		$this->endCaching(false);
	
		return $this->get($key) == $data;
	}
}

?>