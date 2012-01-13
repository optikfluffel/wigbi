<?php
/**
 * Wigbi.JS.LanguageHandler class file.
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
 * The Wigbi.JS.LanguageHandler class.
 * 
 * This class can be used to translate language parameters. It works
 * just like the corresponding PHP class.
 * 
 * One IMPORTANT difference between the two classes, is how they are
 * initialized. The PHP class is initialized using a file path while
 * the JavaScript class uses an associative array.
 * 
 * See the documentation for the corresponding PHP class for further
 * information about how to work with languge files.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
class LanguageHandler_ extends IniHandler_
{
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	array	$languageData	The language data that should be handled by the class.
	 */
	public function __construct($languageData = null) { }
	
	
	
	/**
	 * Translate a language parameter.
	 * 
	 * If the language parameter is not found within the loaded data,
	 * it will be returned untranslated.
	 * 
	 * The section parameter is optional and should only be provided
	 * if the parsed INI data contains any sections.
	 * 
	 * @access	public
	 * 
	 * @param	string	$parameter	The parameter to translate.
	 * @param	string	$section	The parameter section, if the INI data contains sections; default blank.
	 * @return	string				Parameter value, if any, else $parameter.
	 */
	public function translate($parameter, $section = "") { return ""; }
}
?>