<?php

/**
 * The Wigbi CacheItem class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi CacheItem class.
 * 
 * This class represents a data item that is cached by the classes
 * in this package.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Cache
 * @version			2.0.0
 */
class CacheItem
{
	private $_data;
	private $_expires;
		
		
	/**
	 * @param	mixed	$data		The data that is to be parsed.
	 * @param	time	$expires	The time when the data expires.
	 */
	public function __construct($data, $expires)
	{
		$this->_data = $data;
		$this->_expires = $expires;
	}
	
	
	/**
	 * The serializable cache data.
	 * 
	 * @return	mixed
	 */
	public function data()
	{
		return $this->_data;
	}
	
	/**
	 * Whether the data has expired or not.
	 * 
	 * @return	bool
	 */
	public function expired()
	{
		return time() > $this->_expires;
	}
	
	/**
	 * The time when the data expires.
	 * 
	 * @return	time
	 */
	public function expires()
	{
		return $this->_expires;
	}
}

?>