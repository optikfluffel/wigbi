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
		?>
		
		<form id="<?php print $plugin->getChildId("form") ?>">
			<input type="hidden" id="<?php print $plugin->getChildId("idInput") ?>" value="<?php print $obj->id() ?>" />
			<input type="hidden" id="<?php print $plugin->getChildId("parentIdInput") ?>" value="<?php print $obj->parentId() ?>" />
			
			<div class="input-title name"><?php print $plugin->translate("name") ?>:</div>
			<div class="input name"><input type="text" id="<?php print $plugin->getChildId("nameInput") ?>" value="<?php print $obj->name() ?>" /></div>
			
			<div class="input-title url"><?php print $plugin->translate("url") ?>:</div>
			<div class="input url"><input type="text" id="<?php print $plugin->getChildId("urlInput") ?>" value="<?php print $obj->url() ?>" /></div>
			
			<div class="input-title text"><?php print $plugin->translate("text") ?>:</div>
			<div class="input text"><input type="text" id="<?php print $plugin->getChildId("textInput") ?>" value="<?php print $obj->text() ?>" /></div>
			
			<div class="input-title tooltip"><?php print $plugin->translate("tooltip") ?>:</div>
			<div class="input tooltip"><input type="text" id="<?php print $plugin->getChildId("tooltipInput") ?>" value="<?php print $obj->tooltip() ?>" /></div>
			
			<div class="formButtons">
				<input type="reset" id="<?php print $plugin->getChildId("reset") ?>"  value="<?php print $plugin->translate("reset") ?>" />
				<input type="submit" id="<?php print $plugin->getChildId("submit") ?>"  value="<?php print $plugin->translate("submit") ?>" />
			</div>
		</form>

		<script type="text/javascript">
			var <?print $id ?> = new MenuItemForm("<?print $id ?>");
		</script>
		
		<?php
		$plugin->endPluginDiv();
		return $plugin->endPlugin();
	}
}

?>