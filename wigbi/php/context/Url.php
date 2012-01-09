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
	private $_data;
	
	
	/**
	 * Create an instance of the class by parsing an url string.
	 * 
	 * @param	string	$url	The url string to parse.
	 */
	public function __construct($url = "")
	{
		$this->_data = parse_url($url);
	}
	
	
	/**
	 * Get the default instance of the class.
	 * 
	 * @return	IUrl
	 */
	public static function current()
	{
		if (Url::$_current == null)
			Url::$_current = new Url(Url::getCurrentString());
		return Url::$_current;
	}
	
	
	/**
	 * Get the url scheme, e.g. http.
	 * 
	 * @return	string
	 */
	function scheme()
	{
		return $this->getArrayElement("scheme");		
	}
	
	/**
	 * Get the user part of the url, if any.
	 * 
	 * @return	string
	 */
	function user()
	{
		return $this->getArrayElement("user");
	}
	
	/**
	 * Get the password part of the url, if any.
	 * 
	 * @return	string
	 */
	function password()
	{
		return $this->getArrayElement("pass");
	}
	
	/**
	 * Get the url host, e.g. localhost.
	 * 
	 * @return	string
	 */
	function host()
	{
		return $this->getArrayElement("host");
	}
	
	/**
	 * Get the port part of the url, if any.
	 * 
	 * @return	string
	 */
	function port()
	{
		return $this->getArrayElement("port");
	}
	
	/**
	 * Get the absolute url path.
	 * 
	 * @return	string
	 */
	function path()
	{
		return $this->getArrayElement("path");
	}
	
	/**
	 * Get the query part of the url, if any.
	 * 
	 * @return	string
	 */
	function query()
	{
		return $this->getArrayElement("query");		
	}
	
	/**
	 * Get the anchor part of the url, if any.
	 * 
	 * @return	string
	 */
	function fragment()
	{
		return $this->getArrayElement("fragment");		
	}
	
	
	/**
	 * Get a certain data array element.
	 * 
	 * @return	string
	 */
	private function getArrayElement($key)
	{
		if (array_key_exists($key, $this->_data))
			return $this->_data[$key];
		return null;
	}
	
	/**
	 * Get the current url path.
	 * 
	 * @return	string
	 */
	private static function getCurrentString()
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