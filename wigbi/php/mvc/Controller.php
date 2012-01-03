<?php

/**
 * Wigbi Controller class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi Controller class.
 * 
 * This class represents a general MVC controller and can handle a
 * request by providing it with either a view or data. 
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.MVC
 * @version			2.0.0
 */
class Controller implements IController
{
	/**
	 * Execute a certain action.
	 * 
	 * The action name must represent a method that is defined for
	 * the executing controller.
	 * 
	 * @return	mixed	Action result, which will be written to the client.
	 */
	function executeAction($actionName)
	{
		eval('$result = $this->'. $actionName . '();');
		return $result;
	}
}

?>