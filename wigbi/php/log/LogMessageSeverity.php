<?php

/**
 * The Wigbi LogMessageSeverity class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi LogMessageSeverity class.
 * 
 * This class provides static methods that each returns an integer
 * that represents how important a log message is. 0 represents an
 * emergency (most critical) message and 7 a non-important message.    
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Log
 * @version			2.0.0
 */
class LogMessageSeverity
{
	public static function emergency() { return 0; }
	public static function alert() { return 1; }
	public static function critical() { return 2; }
	public static function error() { return 3; }
	public static function warning() { return 4; }
	public static function notice() { return 5; }
	public static function info() { return 6; }
	public static function debug() { return 7; }
}

?>