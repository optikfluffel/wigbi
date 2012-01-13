<?php
/**
 * Wigbi.JS.ValidationHandler class file.
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
 * The Wigbi.JS.ValidationHandler class.
 * 
 * This class can be used to validate various types of data. It is a
 * help class that is used by many plugins in the Wigbi framework.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 * 
 * @static
 */
class ValidationHandler_
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
    public static function isEmail($string) { return true; }
	
	/**
	 * Validate if a string represents a hexadecimal color, e.g. #abcdef.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$string		The string to validate
	 * @return	bool				Whether or not the string is valid.
	 */
    public static function isHexColor($string) { return true; }
	
	/**
	 * Validate if a string is a valid http/https/ftp url.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$string		The string to validate
	 * @return	bool				Whether or not the string is valid.
	 */
    public static function isUrl($string) { return true; }
}
?>