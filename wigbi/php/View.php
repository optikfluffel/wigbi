<?php

/**
 * Wigbi.PHP.View class file.
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
 * The Wigbi.PHP.View class.
 * 
 * This class represents a general view, that can be used in an MVC
 * based application. The class is static, since only one view at a
 * time is handled by Wigbi, even for nested views.
 * 
 * Note that the class can be used for non-MVC applications as well.
 * It contains a set of static methods that can be used for working
 * with the DOM, like adding elements, opening / closing forms etc.
 * 
 * To add a view to the page, which can be done in the controller as
 * well as within in any view, just use the View::addView() function.
 * 
 * Data can be passed to a view using the associative ViewData array
 * property, which is available to all views, or by simply passing a
 * custom model object as a second optional parameter to the addView
 * method. The model will only be available to that particular view.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			0.5
 * 
 * @static
 */
class View
{	
	/**#@+
	 * @ignore
	 */
	private static $_model;
	private static $_outerModels = array();
	private static $_viewData = array();
	/**#@-*/
	
	
	
	/**
	 * Get the currently available view model.
	 * 
	 * @access	public
	 * 
	 * @static
	 * 
	 * @return	string 		The current view model.
	 */
	public function model()
	{
		return View::$_model;
	}
	
	/**
	 * Get/set custom view data values.
	 * 
	 * @access	public
	 * 
	 * @param		string	$key		Data key name.
	 * @param		string	$value	Optional set value.
	 * @return	string		 			The view data value.
	 */
	public function viewData($key, $value = "")
	{
		if (func_num_args() > 1)
			View::$_viewData[$key] = $value;
		return array_key_exists($key, View::$_viewData) ? View::$_viewData[$key] : null;
	}
	
	
	
	/**
	 * Add a button element to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The ID of the element.
	 * @param	string	$text				The text to display in the element.
	 * @param	string	$onclick		The onclick event to use for the element; default none.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addButton($id, $text, $onclick = "", $attributes = "")
	{
		View::addElement("button", array("id" => $id, "onclick" => $onclick), $attributes, $text);
	}
	
	/**
	 * Add a checkbox input element (input type="checkbox") to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The ID of the element.
	 * @param	string	$checked		Whether or not the checkbox should be checked; default false.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addCheckBox($id, $checked = false, $attributes = "")
	{
		$arguments = array("type" => "checkbox", "id" => $id);
		if ($checked)
			$arguments["checked"] = "checked";
			
		View::addElement("input", $arguments, $attributes, "", false);
	}
	
	/**
	 * Add a div element to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The id of the element.
	 * @param	string	$content		The content of the div; default blank.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addDiv($id, $text = "", $attributes = "")
	{
		View::addElement("div", array("id" => $id), $attributes, $text);
	}
	
	/**
	 * Add an HTML element to the page.
	 * 
	 * @access	public
	 * 
	 * @param		string	$name							The name of the element; e.g. img.
	 * @param		array		$attributes				Associative array with element attributes; default empty.
	 * @param		string	$customAttributes	Custom attribute string to add after the array-based attributes; default blank.
	 * @param		string	$elementBody			The element's body content, if any; default blank.
	 * @param		string	$endTag						Whether or not the element should use an end tag; default true and always true if $elementBody is set.
	 * @param		string	$parseWebUrl			Whether or not to convert ~/ to the web root; default true.
	 * @return	string										The resulting element string.
	 */
	public function addElement($name, $attributes = array(), $customAttributes = "", $elementBody = "", $endTag = true, $parseWebUrl = true)
	{
		$result = "<$name ";
		foreach($attributes as $key => $value)
			$result .= $value ? "$key=\"$value\" " : "";
		$result .= $customAttributes ? $customAttributes . " " : "";
		$result .= $elementBody || $endTag ? ">" : "/>";
		$result .= $elementBody;
		$result .= $elementBody || $endTag ? "</$name>" : "";
		
		print $parseWebUrl ? UrlHandler::parseWebUrl($result) : $result;
	}
	
	/**
	 * Add a hidden input element (input type="hidden") to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The ID of the element.
	 * @param	string	$value			The value of the element; default blank.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addHiddenInput($id, $value = "", $attributes = "")
	{
		View::addElement("input", array("type" => "hidden", "id" => $id, "value" => $value), $attributes, "", false);
	}
	
	/**
	 * Add a password input element (input type="password") to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The ID of the element.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addPasswordInput($id, $attributes = "")
	{
		View::addElement("input", array("type" => "password", "id" => $id), $attributes, "", false);
	}
	
	/**
	 * Add a reset input element (input type="reset") to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The ID of the element.
	 * @param	string	$text				The button text.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addResetButton($id, $text, $attributes = "")
	{
		View::addElement("input", array("type" => "reset", "id" => $id, "value" => $text), $attributes, "", false);
	}
	
	/**
	 * Add a span element to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The id of the element.
	 * @param	string	$content		The content of the span; default blank.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addSpan($id, $text = "", $attributes = "")
	{
		View::addElement("span", array("id" => $id), $attributes, $text);
	}
	
	/**
	 * Add a submit input element (input type="submit") to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The ID of the element.
	 * @param	string	$text				The button text.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addSubmitButton($id, $text, $attributes = "")
	{
		View::addElement("input", array("type" => "submit", "id" => $id, "value" => $text), $attributes, "", false);
	}
	
	/**
	 * Add a text area element to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The ID of the element.
	 * @param	string	$content		The content of the element; default blank.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addTextArea($id, $content = "", $attributes = "")
	{
		View::addElement("textarea", array("id" => $id), $attributes, $content, true, false);
	}
	
	/**
	 * Add a text input element (input type="text") to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The ID of the element.
	 * @param	string	$value			The value of the element; default blank.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function addTextInput($id, $value = "", $attributes = "")
	{
		View::addElement("input", array("type" => "text", "id" => $id, "value" => $value), $attributes, "", false, false);
	}
	
	/**
	 * Add a view to the page or current view.
	 * 
	 * If ~/ is used in the view path, Wigbi will auto-parse it to the
	 * application root path.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$viewPath	The path to the view file.
	 * @param	string	$mmodel		Optional view model; default null.
	 */
	public static function addView($viewPath, $model = null)
	{
		array_push(View::$_outerModels, View::$_model);
		
		View::$_model = $model;
		require surl($viewPath);
		
		View::$_model = array_pop(View::$_outerModels);
	}
	
	
	/**
	 * Add a form closing element to the page.
	 * 
	 * @access	public
	 */
	public function closeForm()
	{
		print "</form>";
	}
	
	/**
	 * Add an form opening tag to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id					The ID of the element.
	 * @param	string	$action			The action of the form; default blank.
	 * @param	string	$onsubmit		The onsubmit event of the form; default blank.
	 * @param	string	$attributes	Optional, additional attributes to apply to the element; default blank.
	 */
	public function openForm($id, $action = "", $onsubmit = "", $attributes = "")
	{
		ob_start();
		View::addElement("form", array("id" => $id, "action" => $action, "onsubmit" => $onsubmit), $attributes, "", false);
		$result = ob_get_clean(); 
		
		print str_replace(" />", ">", $result);
	}
}

?>