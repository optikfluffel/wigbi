<?php

/**
 * Wigbi.Plugins.UI.MenuItemForm PHP class file.
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
 * The Wigbi.Plugins.UI.MenuItemForm PHP class.
 * 
 * This plugin displays a form, with which existing MenuItem objects
 * can be saved or new ones created.
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality:
 * 
 * 	<ul>
 * 		<li>[AJAX] public void add(string id, mixed objectOrId, string objectName, string targetContainerId, function onAdd())</li>
 * 		<li>[AJAX] public void setObject(MenuItem object)</li>
 * 		<li>[AJAX] public void submit()</li>
 * 		<li></li>
 * 		<li>[VIRTUAL] public void onSubmit(MenuItem obj)</li>
 * 	</ul>
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.UI
 * @version			1.0.2
 */
class MenuItemForm extends WigbiUIPlugin
{
	/**
	 * Create an instance of the class. 
	 * 
	 * @access	public
	 * 
	 * @param	string	$id		The unique plugin instance ID.
	 */
	public function __construct($id)
	{
		parent::__construct($id);
	}

	
	/**
	 * Add a MenuItemForm to the page. 
	 * 
	 * $objectOrId can either be an object instance or an ID. Objects can
	 * also be loaded by name, but only one of the parameters can be used.
	 * 
	 * If neither $objectOrId nor $objectName is set, the plugin will use
	 * a default, unsaved object.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$objectOrId		The object or the ID of the object to load into the form.
	 * @param		string	$objectName		The name of the object to load into the form.
	 */
	public static function add($id, $objectOrId, $objectName)
	{
		$obj = new MenuItem();
		$obj = $obj->loadOrInit($objectOrId, $objectName, "name");
		if (!$obj->name())
			$obj->name($objectName);
		
		$plugin = new MenuItemForm($id);
		$plugin->beginPlugin();
		$plugin->beginPluginDiv();
		
		View::openForm($plugin->getChildId("form"));
		View::addHiddenInput($plugin->getChildId("idInput"), $obj->id());
		View::addHiddenInput($plugin->getChildId("parentIdInput"), $obj->parentId());
		View::addDiv($plugin->getChildId("nameInputTitle"), $plugin->translate("name") . ":", "class='input-title'");
			View::addTextInput($plugin->getChildId("nameInput"), $obj->name(), "");
		View::addDiv($plugin->getChildId("urlInputTitle"), $plugin->translate("url") . ":", "class='input-title'");
			View::addTextInput($plugin->getChildId("urlInput"), $obj->name(), "");
		View::addDiv($plugin->getChildId("textInputTitle"), $plugin->translate("text") . ":", "class='input-title'");
			View::addTextInput($plugin->getChildId("textInput"), $obj->name(), "");
		View::addDiv($plugin->getChildId("tooltipInputTitle"), $plugin->translate("tooltip") . ":", "class='input-title'");
			View::addTextInput($plugin->getChildId("tooltipInput"), $obj->name(), "");
		?>
		
		<div class="formButtons"><?php
			View::addResetButton($plugin->getChildId("reset"), $plugin->translate("reset"));
			View::addSubmitButton($plugin->getChildId("submit"), $plugin->translate("save"));
		?></div>
		
		<?php View::closeForm(); ?>

		<script type="text/javascript">
			var <?print $id ?> = new MenuItemForm("<?print $id ?>");
		</script>
		
		<?php
		$plugin->endPluginDiv();
		return $plugin->endPlugin();
	}
}

?>