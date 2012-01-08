<?php

/**
 * The Wigbi Url class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi Url class.
 * 
 * This class can be used to handle URLs in various ways. It has a
 * static current method as well, which returns the current url.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Context
 * @version			2.0.0
 */
class Url implements IUrl
{
	private static $_current;
	
	
	
	/**
	 * Create an instance of the class by parsing an url string.
	 * 
	 * @param	string	$url	The url string to parse.
	 */
	public function __construct($str = "")
	{
		$data = parse_url($url);
	}
	
	
	
	
	/**
	 * Get the default instance of the class.
	 * 
	 * @return	IUrl
	 */
	public static function current()
	{
		if (Url::$_current == null)
			Url::$_current = new Url(Url::currentString());
		return Url::$_current;
	}
	
	
	/**
	 * Get the current url path.
	 * 
	 * @return	string
	 */
	public static function currentString()
	{
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;

		$server = $_SERVER['SERVER_NAME'];
		
		$port = ($_SERVER["SERVER_PORT"] == "80" && $ignorePort80) ? "" : ($_SERVER["SERVER_PORT"]);
		$port = $port ? ":" . $port : "";
		
		$path = $_SERVER['REQUEST_URI'];
		
		return $protocol . "://" . $server . $port . $path;
	}
	
}

?>