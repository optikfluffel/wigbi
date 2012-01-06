<?php
/**
 * Wigbi.JS.Core.WigbiUIPlugin class file.
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
 * The Wigbi.JS.Core.WigbiUIPlugin class.
 * 
 * This base class can be used to provide Wigbi UI plugins with base
 * functionality. For the class methods to work properly a UI plugin
 * must inherit the class. 
 * 
 * See the documentation for the corresponding PHP class for further
 * information about how to work with UI plugins.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS.Core
 * @version			1.0.0
 * 
 * @abstract
 */
abstract class WigbiUIPlugin_ extends WigbiClass_
{
	/**
	 * Create an instance of the class.
	 * 
	 * The id parameter must be unique to make sure that each plugin
	 * instance can be identified. However, if a plugin does not use
	 * the ID property, it can just set it to nothing.   
	 * 
	 * @access	public
	 * 
	 * @param	string	$id	The unique plugin instance ID.
	 */
	public function __construct($id) { }
	
	
	
	/**
	 * Get the unique instance ID, which is set by the base constructor.
	 * 
	 * @access	public
	 * 
	 * @return	string	The unique instance ID.
	 */
	public function id() { return ""; }
	
	
	 
	/**
	 * Bind validation result to DOM elements.
	 * 
	 * This method is extensively used by form-based UI plugins that
	 * are shipped with Wigbi. For the method to work as intended, a
	 * plugin must fulfill two conditions:
	 * 
	 * 	<ul>
	 * 		<li>Plugin elements use <pluginId>-<elementId> for their IDs</li>
	 * 		<li>The provided error codes begin with <elementId></li>
	 * 	</ul>
	 * 
	 * Affected elements will have an "error" CSS class added, which
	 * is styled in one of the default wigbi CSS files. 
	 * 
	 * @access	public
	 * 
	 * @param	array	$elementIds	A list of element IDs that are to be affected.
	 * @param	array	$errorList	A list with validation errors.
	 */
	public function bindErrors($elementIds, $errorCodes) { }
	
	/**
	 * Retrieve a certain element from the plugin DOM.
	 * 
	 * The element ID must be "<pluginId>-$elementName". 
	 * 
	 * @access	public
	 * 
	 * @param		string	$elementName	The name of the element.
	 * @return	mixed									The DOM element.
	 */
	public function getElement($elementName) { }
	
	/**
	 * Retrieve data that is stored as JSON withinin a certain element in the plugin DOM.
	 * 
	 * The element ID must be "<pluginId>-$elementName".
	 * 
	 * @access	public
	 * 
	 * @param		string	$elementName	The name of the element.
	 * @param		string	$baseObject		The object that will inherit the decoded data.
	 * @return	mixed									The decoded data.
	 */
	public function getElementData($elementName, $baseObject) { }
	
	/**
	 * [VIRTUAL] Reset the plugin, if applicable.
	 */
	this.reset = function() { };
	
	/**
	 * [VIRTUAL] Submit the plugin, if applicable.
	 */
	this.submit = function() { };
	
	/**
	 * Translate a string, using the Wigbi languageHandler instance.
	 * 
	 * This function applies the correct prefix to the string so that
	 * is can be customized. Before being translated, it is converted
	 * to "<id> <className> <originalString>".
	 * 
	 * @access	public
	 * 
	 * @param		string	$str	The string to translate.
	 * @return	string				The translation.
	 */
	public function translate($str) { }
}
?>
