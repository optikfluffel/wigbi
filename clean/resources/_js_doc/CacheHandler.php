<?php
/**
 * Wigbi.JS.CacheHandler class file.
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
 * The Wigbi.JS.CacheHandler class.
 * 
 * This class can be used to save and retrieve cached data. It fully
 * supports all serializible data and can thus store complex objects
 * as well as simple strings, integers etc.
 * 
 * Since this class is based on asynchronous methods, the cache data
 * will be handled by both JavaScript and PHP. Thus, complex objects
 * should not be cached without being serialized first.  
 * 
 * One important difference between the PHP and the JavaScript class
 * is that the cacheFolder property must be PAGE RELATIVE in PHP and
 * APPLICATION RELATIVE in JavaScript.   
 * 
 * See the documentation for the corresponding PHP class for further
 * information about how to work with caching.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
class CacheHandler_ extends WigbiClass_
{
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	string	$cacheFolder	The path to the cache folder.
	 */
	public function __construct($cacheFolder) { }
	
	
	
	/**
	 * Get/set the path to the cache folder.
	 * 
	 * @access	public
	 * 
	 * @param	string	$value	Optional set value.
	 * @return	string			The path to the cache folder.
	 */
	public function cacheFolder($value = "") { }
	
	
	
	/**
	 * [ASYNC] Clear any cached data.
	 * 
	 * Callback method signature: onClear(bool success) 
	 * 
	 * @access	public
	 * 
	 * @param	string		$key		The cache data key name.
	 * @param	function	$onClear	Raised when the AJAX call returns a response.
	 */
    public function clear($key, $onClear) { }
	
	/**
	 * [ASYNC] Retrieve cached data.
	 * 
	 * This function retrieves any previously cached data from file. 
	 * 
	 * Callback method signature: onGet(object data) 
	 * 
	 * @access	public
	 * 
	 * @param	string		$key	The cache data key name.
	 * @param	function	$onGet	Raised when the AJAX call returns a response.
	 */
    public function get($key, $onGet) { }
	
	/**
	 * Get an object that can be used in asynchronous operations. 
	 * 
	 * @access	private
	 * 
	 * @return	CacheHandler	Raised when the AJAX call returns a response.
	 */
    private function getRequestObject() { return null; }
	
	/**
	 * [ASYNC] Cache any serializable data.
	 * 
	 * This function takes any serializable data and writes it to a
	 * cache file that is created in the defined cache folder.
	 *  
	 * Callback method signature: onSet(bool success) 
	 * 
	 * @access	public
	 * 
	 * @param	string		$key			The cache data key name.
	 * @param	mixed		$data			The data that is to be cached.
	 * @param	int			$validityTime	The time, in minutes, for how long the data is valid.
	 * @param	function	$onSet			Raised when the AJAX call returns a response.
	 */
    public function set($key, $data, $validityTime, $onSet) { }
}
?>