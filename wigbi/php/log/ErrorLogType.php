<?php

/**
 * The Wigbi ErrorLogType class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ErrorLogType class.
 * 
 * This class provides static methods that each returns an integer
 * that each represents how an ErrorLog instance will log messages.    
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Log
 * @version			2.0.0
 */
class ErrorLogType
{
	public static function system() { return 0; }
	public static function email() { return 1; }
	public static function file() { return 3; }
	public static function sapi() { return 4; }
}

?>