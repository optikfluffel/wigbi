<?php

/**
 * Wigbi.Plugins.UI.HtmlContentControl PHP class file.
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
 * The Wigbi.Plugins.UI.HtmlContentControl PHP class.
 * 
 * This plugin can be used to display the content of any HtmlContent
 * data plugin instance.
 * 
 * The plugin can also embed a form, with which existing objects can
 * be saved or new ones created. The form is automatically displayed
 * if the target object is unsaved.
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality:
 * 
 * 	<ul>
 * 		<li>[AJAX] public void add(string id, mixed objectOrId, string objectName, bool embedForm, string targetContainerId, function onAdd())</li>
 * 		<li>[AJAX] public void setObject(HtmlContent object)</li>
 * 		<li>[AJAX] public void submit()</li>
 * 		<li></li>
 * 		<li>[VIRTUAL] public void onSubmit(HtmlContent obj)</li>
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
class HtmlContentControl extends WigbiUIPlugin
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
	 * Add a HtmlContentControl to the page. 
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
	 * @param		bool		$embedForm		Whether or not to embed an form; default false.
	 */
	public static function add($id, $objectOrId, $objectName, $embedForm = false)
	{
		$obj = new HtmlContent();
		$obj = $obj->loadOrInit($objectOrId, $objectName, "name");
		if (!$obj->name())
			$obj->name($objectName);
		
		$plugin = new HtmlContentControl($id);
		$plugin->beginPlugin();
		$plugin->beginPluginDiv();
		
		
		if ($embedForm)
			$plugin->beginViewDiv($embedForm && $obj->id()); ?>
		<input type="hidden" id="<?php print $plugin->getChildId("idInput") ?>" value="<?php print $obj->id() ?>" />
		
		<?php /* View area ********** */ ?>
		<div id="<?php print $plugin->getChildId("content"); ?>">
			<?php pwurl($obj->content()); ?>
		</div> 

		<?php /* Form area ********** */
		if ($embedForm)
		{
			$plugin->endViewDiv();
			$plugin->beginEditDiv($embedForm && !$obj->id()); ?>
		
			<form id="<?php print $plugin->getChildId("form") ?>">
				<div class="input-title name"><?php print $plugin->translate("name") ?>:</div>
				<div class="input name"><input type="text" id="<?php print $plugin->getChildId("nameInput") ?>" value="<?php print $obj->name() ?>" /></div>
				
				<div class="input-title content"><?php print $plugin->translate("content") ?>:</div>
				<div class="input content"><textarea id="<?php print $plugin->getChildId("contentInput") ?>" class="wysiwyg advanced"><?php print $obj->content() ?></textarea></div>
				
				<div class="formButtons">
					<input type="reset" id="<?php print $plugin->getChildId("reset") ?>"  value="<?php print $plugin->translate("reset") ?>" />
					<input type="submit" id="<?php print $plugin->getChildId("submit") ?>"  value="<?php print $plugin->translate("submit") ?>" />
				</div>
			</form>
			
			<?php
			$plugin->endEditDiv();	
		} ?>

		<script type="text/javascript">
			var <?print $id ?> = new HtmlContentControl("<?print $id ?>");
		</script>
		
		<?php
		$plugin->endPluginDiv();
		return $plugin->endPlugin();
	}
}

?>