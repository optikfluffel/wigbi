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
 * This plugin can be used to edit an HtmlContent object. The plugin
 * form is submitted with AJAX.
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
	 * $objectOrId can either be an object instance or an ID. The object
	 * can also be loaded by name. However, if one parameter is set, set
	 * the other to an empty string.
	 *    
 	 * This plugin will print the resulting HTML directly to the page if
	 * the method is called directly and not via AJAX.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$objectOrId		The ID of the object to load into the form.
	 * @param		string	$objectName		The name of the object to load into the form.
	 * @return	string								The resulting HTML, if any.
	 */	 
	public static function add($id, $objectOrId, $objectName)
	{
		$plugin = new HtmlContentForm($id);
		$obj = new HtmlContent();
		$obj = $obj->loadOrInit($objectOrId, $objectName, "name");
		
		ob_start();
		$plugin->beginPluginDiv();
		
		$plugin->addTextArea("object", json_encode($obj), null, "hide");
		$plugin->addTextBox("name", $obj->name() ? $obj->name() : $objectName, $plugin->translate("name"). ":", "");
		$plugin->addTextArea("content", $obj->content(), $plugin->translate("content"). ":", "wysiwyg advanced");
		?>
		
		<div class="buttons">
			<?php
				$plugin->addButton("resetButton", "reset", $plugin->translate("reset"));
				$plugin->addButton("submitButton", "submit", $plugin->translate("save"));
			?>
		</div>
		
		<script type="text/javascript">
				var <?print $id ?> = new HtmlContentForm("<?print $id ?>");
		</script>
		
		<?php
		$plugin->endPluginDiv();
		$result = ob_get_clean();
		
		if (!Wigbi::isAjaxPostback())
			print $result;
		return Wigbi::isAjaxPostback() ? $result : "";
	}
}

?>