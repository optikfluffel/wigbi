<?php

/**
 * Wigbi.Plugins.UI.HtmlContentForm PHP class file.
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
 * The Wigbi.Plugins.UI.HtmlContentForm PHP class.
 * 
 * This plugin can be used to create and / or edit a MenuItem object.
 * The form is submitted with AJAX, without reloading the page.
 * 
 * If objectOrId or objectName are set when adding a plugin instance
 * to the page, the plugin will modify that object. If not, the form
 * will create a new HtmlContent object when it is submitted.
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality:
 * 
 * 	<ul>
 * 		<li>public HtmlContent obj([HtmlContent newValue])</li>
 * 		<li></li>
 * 		<li>[AJAX] public void add(string id, string objectId, string objectName, string targetContainerId, function onAdd())</li>
 * 		<li>[AJAX] public void submit()</li>
 * 		<li>public void reset()</li>
 * 		<li></li>
 * 		<li>[VIRTUAL] public void onSubmit()</li>
 * 	</ul>
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.UI
 * @version			1.0.0
 */
class HtmlContentForm extends WigbiUIPlugin
{
	/**
	 * Create an instance of the class. 
	 * 
	 * @access	public
	 * 
	 * @param	string	$id	The unique plugin instance ID.
	 */
	public function __construct($id)
	{
		parent::__construct($id);
	}
	
	
	
	/**
	 * Add a HtmlContentForm to the page. 
	 * 
	 * If neither the $objectOrId nor the $objectName parameter is set,
	 * the plugin will handle a default, unsaved object.
	 * 
	 * The $objectOrId parameter can either be an object instance or a
	 * unique object ID. If this parameter is set, set the $objectName
	 * parameter to an empty string and vice versa.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$objectOrId		The object or the ID of the object to handle with the plugin.
	 * @param		string	$objectName		The name of the object to handle with the plugin.
	 */	 
	public static function add($id, $objectOrId, $objectName)
	{
		$plugin = new HtmlContentForm($id);
		$obj = new HtmlContent();
		$obj = $obj->loadOrInit($objectOrId, $objectName, "name");
		
		if (!$obj->name())
			$obj->name($objectName);
	
		$plugin->beginPlugin();
		$plugin->beginPluginDiv();
		
		View::openForm($plugin->getChildId("form"));
		View::addTextArea($plugin->getChildId("object"), json_encode($obj), "style='display:none'");
		
		View::addDiv($plugin->getChildId("nameTitle"), $plugin->translate("name") . ":", "class='input-title'");
		View::addTextInput($plugin->getChildId("name"), $obj->name(), "");
		
		View::addDiv($plugin->getChildId("contentTitle"), $plugin->translate("content") . ":", "class='input-title'");
		View::addTextArea($plugin->getChildId("content"), $obj->content(), "class='wysiwyg advanced'");
		?>
		
		<div class="formButtons"><?php
			View::addButton($plugin->getChildId("reset"), $plugin->translate("reset"), $id . ".reset(); return false;");
			View::addSubmitButton($plugin->getChildId("submit"), $plugin->translate("save"));
		?></div>
		
		<script type="text/javascript">
			var <?print $id ?> = new HtmlContentForm("<?print $id ?>");
		</script>
		
		<?php
		View::closeForm();

		$plugin->endPluginDiv();
		return $plugin->endPlugin();
	}
}

?>