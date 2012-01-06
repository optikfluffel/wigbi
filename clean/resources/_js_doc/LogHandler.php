<?php
/**
 * Wigbi.JS.LogHandler class file.
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
 * The Wigbi.JS.LogHandler class.
 * 
 * This class can be used to log messages in various ways. Some log
 * targets require an asynchronous server call to the corresponding
 * PHP class while others are executed client-side.
 * 
 * One important difference between the PHP and the JavaScript class
 * is that the file property of every sub handler has got to be PAGE
 * RELATIVE in PHP and APPLICATION RELATIVE in JavaScript.
 * 
 * See the documentation for the corresponding PHP class for further
 * information about how to work with logging.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
class LogHandler_ extends WigbiClass_
{
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id		The id string that will be added to the logged data; default empty.
	 */
	public function __construct($id = "") { }
	
	
	
	/**
	 * Get the list of added sub log handlers.
	 * 
	 * @access	public
	 * 
	 * @return	array	The list of added sub log handlers.
	 */
	public function handlers() { return array(); }
	
	/**
	 * Get/set the id string that will be added to the logged data.
	 * 
	 * @access	public
	 * 
	 * @param	string	$value	Optional set value.
	 * @return	string			The id string that will be added to the logged data.
	 */
	public function id($value = "") { return ""; }

	
	
	/**
	 * Add a sub log handler to the log handler. 
	 * 
	 * See the class documentation of the PHP class for further info
	 * about how to use sub log handlers. 
	 * 
	 * @access	public
	 * 
	 * @param	array	$priorities		A list of priority levels that the handle should handle.
	 * @param	bool	$display		Whether or not to log to screen.
	 * @param	string	$file			Path to a log file to log to, if any.
	 * @param	bool	$firebug		Whether or not to log to firebug.
	 * @param	string	$mailaddresses	A comma-separated list of e-mail addresses to which log messages should be sent.
	 * @param	bool	$syslog			Whether or not to log to the system log.
	 * @param	bool	$window			Whether or not to log to a log window.
	 */
	public function addHandler($priorities, $display, $file, $firebug, $mailaddresses, $syslog, $window) { }
	
	/**
	 * [ASYNC] Log a message with a certain priority level.
	 * 
	 * Callback method signature: onLog(bool success)
	 * 
	 * This method only use asynchronous calls for the following log
	 * target: file, mailaddresses and syslog. The onLog callback is
	 * only called if an asynchronous call is made by the method.     
	 * 
	 * @access	public
	 * 
	 * @param	string		$message		The message to log.
	 * @param	int			$priority		The message priority level.
	 * @param	function	$onLog			Raised when the AJAX call returns a response.
	 */
	public function log($message, $priority, $onLog) { }
}
?>