<?php

/**
 * Wigbi.PHP.ValidationHandler class file.
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
 * The Wigbi.PHP.ValidationHandler class.
 * 
 * This class can be used to validate various types of data. It is a
 * help class that is used by many plugins in the Wigbi framework.
 * 
 * The class does not only provide string and integer validation. It
 * can, for instance, also validate whether or not an URL exists.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 * 
 * @static
 */
class ValidationHandler
{
	/**
	 * Validate if a string is a valid e-mail address.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$string		The string to validate
	 * @return	bool				Whether or not the string is valid.
	 */
	public static function isEmail($string)
	{
		return preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $string);
	}
	
	/**
	 * Validate if a string represents a hex color, e.g. #abcdef.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$string		The string to validate
	 * @return	bool				Whether or not the string is valid.
	 */
	public static function isHexColor($string)
	{
		return preg_match('/^#(?:(?:[a-fd]{3}){1,2})$/i', $string);
	}
	
	/**
	 * Validate if a string is a valid http/https/ftp url.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$string		The string to validate
	 * @return	bool				Whether or not the string is valid.
	 */
	public static function isUrl($string)
	{
		return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i', $string);
	}
	
	/**
	 * Validate if a certain url really exists.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$url	The url to validate
	 * @return	string			The url data, if the URL existed.
	 */
	public static function urlExists($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}

?>