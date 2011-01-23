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
 * @version			1.0.2
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
}

?>