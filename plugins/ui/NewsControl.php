<?php

/**
 * Wigbi.Plugins.UI.NewsControl PHP class file.
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
 * The Wigbi.Plugins.UI.NewsControl PHP class.
 * 
 * This plugin can be used to display the content of any News object.
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
 * 		<li>[AJAX] public void submit()</li>
 * 		<li></li>
 * 		<li>[VIRTUAL] public void onSubmit(News obj)</li>
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
class NewsControl extends WigbiUIPlugin
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
	 * Add a NewsControl to the page. 
	 * 
	 * $objectOrId can either be an object instance or an ID. Objects can
	 * also be loaded by title, but only one of the parameters can be set.
	 * 
	 * If neither $objectOrId nor $objectTitle is set the plugin will use
	 * a default, unsaved object.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$objectOrId		The object or the ID of the object to load into the form.
	 * @param		string	$objectTitle	The title of the object to load into the form.
	 * @param		bool		$embedForm		Whether or not to embed an NewsForm; default false.
	 */
	public static function add($id, $objectOrId, $objectTitle, $embedForm = false)
	{
		$obj = new News();
		$obj = $obj->loadOrInit($objectOrId, $objectTitle, "name");
		if (!$obj->title())
			$obj->title($objectTitle);
		
		$plugin = new NewsControl($id);
		$plugin->beginPlugin();
		$plugin->beginPluginDiv();
		
		if ($embedForm)
			$plugin->beginViewDiv($embedForm && $obj->id());
		
		View::addDiv($plugin->getChildId("content"), wurl($obj->content()));
		View::addHiddenInput($plugin->getChildId("objectId"), $obj->id());
		
		if ($embedForm)
		{
			$plugin->endViewDiv();
			$plugin->beginEditDiv($embedForm && !$obj->id());
			
			View::openForm($plugin->getChildId("form"));
			View::addDiv($plugin->getChildId("titleInputTitle"), $plugin->translate("title") . ":", "class='input-title'");
				View::addTextInput($plugin->getChildId("titleInput"), $obj->title(), "");
			View::addDiv($plugin->getChildId("contentInputTitle"), $plugin->translate("content") . ":", "class='input-title'");
				View::addTextArea($plugin->getChildId("contentInput"), $obj->content(), "class='wysiwyg slimmed'");
			?>
			
			<div class="formButtons"><?php
				View::addResetButton($plugin->getChildId("reset"), $plugin->translate("reset"));
				View::addSubmitButton($plugin->getChildId("submit"), $plugin->translate("save"));
			?></div>
			
			<?php
			View::closeForm();
			$plugin->endEditDiv();	
		} ?>

		<script type="text/javascript">
			var <?print $id ?> = new NewsControl("<?print $id ?>");
		</script>
		
		<?php
		$plugin->endPluginDiv();
		return $plugin->endPlugin();
	}
}

?>