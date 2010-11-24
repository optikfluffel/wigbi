<?php

/**
 * Wigbi.Plugins.UI.NewsForm PHP class file.
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
 * The Wigbi.Plugins.UI.NewsForm PHP class.
 * 
 * This plugin can be used to edit a News object. The plugin form is
 * submitted with AJAX, without reloading the page.
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality:
 * 
 * 	<ul>
 * 		<li>public News obj([News newValue])</li>
 * 		<li></li>
 * 		<li>[AJAX] public void add(string id, string objectId, string objectTitle, string targetContainerId, function onAdd())</li>
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
class NewsForm extends WigbiUIPlugin
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
	 * Add a NewsForm to the page. 
	 * 
	 * $objectOrId can either be an object instance or an ID. The object
	 * can also be loaded by title. However, if one parameter is set, do
	 * set the other to an empty string.
	 *    
 	 * This plugin will print the resulting HTML directly to the page if
	 * the method is called directly and not via AJAX.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$objectOrId		The ID of the object to load into the form.
	 * @param		string	$objectTitle	The title of the object to load into the form.
	 * @return	string								The resulting HTML, if any.
	 */	 
	public static function add($id, $objectOrId, $objectTitle)
	{
		$plugin = new NewsForm($id);
		$obj = new News();
		$obj = $obj->loadOrInit($objectOrId, $objectTitle, "title");
		
		if (!$obj->title())
			$obj->title($objectTitle);
	
		$plugin->beginPlugin();
		$plugin->beginPluginDiv();
		View::openForm($plugin->getChildId("form"));
		View::addTextArea($plugin->getChildId("object"), json_encode($obj), "style='display:none'");
		
		View::addDiv($plugin->getChildId("titleTitle"), $plugin->translate("title") . ":", "class='input-title'");
		View::addTextInput($plugin->getChildId("title"), $obj->title(), "");
		
		View::addDiv($plugin->getChildId("contentTitle"), $plugin->translate("content") . ":", "class='input-title'");
		View::addTextArea($plugin->getChildId("content"), $obj->content(), "class='wysiwyg slimmed'");
		?>
		
		<div class="formButtons"><?php
			View::addButton($plugin->getChildId("reset"), $plugin->translate("reset"), $id . ".reset(); return false;");
			View::addSubmitButton($plugin->getChildId("submit"), $plugin->translate("save"));
		?></div>
		
		<script type="text/javascript">
			var <?print $id ?> = new NewsForm("<?print $id ?>");
		</script>
		
		<?php
		View::closeForm();
		$plugin->endPluginDiv();
		return $plugin->endPlugin();
	}
}

?>