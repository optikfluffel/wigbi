<?php

/**
 * Wigbi View class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The View Controller class.
 * 
 * This class does not represent a view. It is rather a class that
 * can be used to handle views.
 * 
 * Use the add method to add a new view to the page. It can either
 * be a root view or a view that is embedded into another one. The
 * view can be passed a model, which can then be accessed with the
 * model method, by that particular view only.
 * 
 * The View class also has a viewData method, which can be used to
 * feed data to all views.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.MVC
 * @version			2.0.0
 */
class View 
{
	private static $_fileIncluder;
	private static $_models = array();
	private static $_viewData = array();
	
	
	/**
	 * Add a view to the page or current view.
	 * 
	 * @param	string	$path		The path to the view file.
	 * @param	string	$mmodel		Optional view model.
	 */
	public static function add($path, $model = null)
	{
		array_push(View::$_models, $model);
		
		View::fileIncluder()->includePath($path, false);
		
		array_pop(View::$_models);
	}
	
	/**
	 * Get/set the file includer that is used to load view files.
	 * 
	 * If no file includer is set, a FileIncluder is used by default.
	 * 
	 * @param	IFileIncluder	$newIncluder	Optional set value.
	 * @return	IFileIncluder
	 */
	public static function fileIncluder($newIncluder = null)
	{
		if (func_num_args() > 0)
			View::$_fileIncluder = func_get_arg(0);
		
		if (!View::$_fileIncluder)
		 	View::$_fileIncluder = new PhpFileIncluder();
		
		return View::$_fileIncluder;
	}
	
	/**
	 * Get the currently available view model.
	 * 
	 * @return	string 		The current view model.
	 */
	public static function model()
	{
		$size = sizeof(View::$_models);
		
		return ($size == 0) ? null : View::$_models[$size-1];
	}
	/**
	 * Get/set custom view data.
	 * 
	 * @param	string	$key	View data key to get/set.
	 * @param	string	$value	Optional set value.
	 * @return	mixed			The value of the view data.
	 */
	public function viewData($key, $value = "")
	{
		if (func_num_args() > 1)
			View::$_viewData[$key] = $value;
		return array_key_exists($key, View::$_viewData) ? View::$_viewData[$key] : null;
	}
}

?>