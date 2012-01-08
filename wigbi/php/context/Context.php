<?php

/**
 * The Wigbi Context class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi Context class.
 * 
 * This class can be used to handle various context related arrays,
 * like $_ENV, $_GET, $_POST and $_REQUEST.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP
 * @version			2.0.0
 */
class Context implements IContext
{
	private static $_instance;
	
	
	/**
	 * Get the default instance of the class.
	 * 
	 * @return	IContext
	 */
	public static function current()
	{
		if (Context::$_instance == null)
			Context::$_instance = new Context();
		return Context::$_instance;
	}
	
	
	/**
	 * Get the value of a certain key in the $_ENV array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function env($key, $fallback = null)
	{
		return Context::getArrayKey($_ENV, $key, $fallback);
	}
	
	/**
	 * Get the value of a certain key in the $_FILES array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function files($key, $fallback = null)
	{
		return Context::getArrayKey($_FILES, $key, $fallback);
	}
	
	/**
	 * Get the value of a certain key in the $_GET array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function get($key, $fallback = null)
	{
		return Context::getArrayKey($_GET, $key, $fallback);
	}
	
	/**
	 * Get the value of a certain key in the $_POST array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function post($key, $fallback = null)
	{
		return Context::getArrayKey($_POST, $key, $fallback);
	}
	
	/**
	 * Get the value of a certain key in the $_REQUEST array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function request($key, $fallback = null)
	{
		return Context::getArrayKey($_REQUEST, $key, $fallback);
	}
	
	/**
	 * Get the value of a certain key in the $_SERVER array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function server($key, $fallback = null)
	{
		return Context::getArrayKey($_SERVER, $key, $fallback);
	}
	
	
	/**
	 * Get the value of a certain key in an array.
	 */
	private static function getArrayKey($array, $key, $fallback = null)
	{
		return array_key_exists($key, $array) ? $array[$key] : $fallback;
	}
}

?>