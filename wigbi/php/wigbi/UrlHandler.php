<?php

/**
 * Wigbi.PHP.UrlHandler class file.
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
 * The Wigbi.PHP.UrlHandler class.
 * 
 * This class can be used to work with URLs, like retriving the full,
 * current URL. The class is quite limited now, but will be extended
 * in the future.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 * 
 * @static
 */
class UrlHandler
{
	/**
	 * Get the port of the current URL.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		string	$ignorePort80	Whether or not port 80 should return a blank result.
	 * @return	string								The port of the current URL.
	 */
	public static function currentPort($ignorePort80 = true)
	{
		$port = ($_SERVER["SERVER_PORT"] == "80" && $ignorePort80) ? "" : ($_SERVER["SERVER_PORT"]);
		
		return $port;
	}
	
	/**
	 * Get the protocol of the current URL.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The protocol of the current URL.
	 */
	public static function currentProtocol()
	{
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
		
		return $protocol;
	}
	
	/**
	 * Get the current URL, including protocol and port.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The current URL.
	 */
	public static function currentUrl()
	{
		$port = UrlHandler::currentPort() ? ":" . UrlHandler::currentPort() : "";
		return UrlHandler::currentProtocol() . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	}
	
	
	
	/**
	 * Parse a server path that has a ~/ in the beginning.
	 * 
	 * The ~/ will be replaced with Wigbi::serverRoot().
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		string	$url	The URL that is to be parsed.
	 * @return	string				The parsed result.
	 */
	public static function parseServerUrl($url)
	{
		return str_replace("~/", Wigbi::serverRoot(), $url);
	}
	
	/**
	 * Parse a server path that has a ~/ in the beginning.
	 * 
	 * The ~/ will be replaced with Wigbi::serverRoot().
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		string	$url	The URL that is to be parsed.
	 * @return	string				The parsed result.
	 */
	public static function parseWebUrl($url)
	{
		return str_replace("~/", Wigbi::webRoot(), $url);
	}
}

?>