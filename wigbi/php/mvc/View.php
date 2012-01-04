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
 * model method by that particular view only.
 * 
 * The View class also has a viewData method, which can be used to
 * provide data to all views.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.MVC
 * @version			2.0.0
 */
abstract class View implements IController
{
	/**
	 * Add a view to the page or to the current view.
	 * 
	 * @param	string	$path	The path to the view file.
	 * @param	string	$model	Optional view model.
	 */
	/*public static function addView($viewPath, $model = null)
	{
		array_push(View::$_outerModels, View::$_model);
		
		View::$_model = $model;
		require surl($viewPath);
		
		View::$_model = array_pop(View::$_outerModels);
	}*/
}

?>