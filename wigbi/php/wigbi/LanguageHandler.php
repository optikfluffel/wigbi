<?php

/**
 * Wigbi.PHP.LanguageHandler class file.
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
 * The Wigbi.PHP.LanguageHandler class.
 * 
 * This class can be used to translate language parameters that have
 * been loaded from a INI language file. 
 * 
 * Language parameters can consist of one or several values, with an
 * empty space between them. When such a parameters is used, add the
 * most specific first and the most general last.
 * 
 * For "myLoginForm LoginForm submit", all these translations apply:
 * 
 * <code>
 *	myLoginForm LoginForm submit=This translation only applies to this very LoginForm
 *	LoginForm submit=This translation applies to all LoginForms that have no translations of their own 
 *	submit=This translation applies to all language terms that ends with the submit parameter
 * </code>
 * 
 * Specific translations override general ones, meaning that if the
 * myLoginForm above would not have had a dedicated translation. It
 * would use the more general "LoginForm submit" instead, and so on.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 */
class LanguageHandler extends IniHandler
{	
	/**#@+
	 * @ignore
	 */
	private $_data = array();
	/**#@-*/
	
	
	
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	string	$filePath	The path to the INI file that is to be parsed, if any.
	 */
	public function __construct($filePath = null)
	{
		parent::__construct($filePath);
	}
	
	
	
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
	 * @param		string	$parameter	The parameter to translate.
	 * @param		string	$section		The parameter section, if the INI data contains sections; default blank.
	 * @return	string							Parameter value, if any, else $parameter.
	 */
	public function translate($parameter, $section = "")
	{
		//Remove term from left to right until a translation is found
		$parameters = explode(" ", $parameter);
		while (sizeof($parameters) > 0)
		{
			//Load the current term from the ini reader
			$tmpParameter = implode(" ", $parameters);
			$translation = parent::get($tmpParameter, $section);
			
			//Return the translation, if any
			if ($translation)
				return $translation;
				
			//Remove the leftmost word and continue
			array_shift($parameters);
		}
		
		//No translation is found - return parameter
		return $parameter;
	}
}

?>