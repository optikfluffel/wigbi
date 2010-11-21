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
 * object. It can also be set to embed a HtmlContentForm plugin with
 * which the object can be edited.
 * 
 * If an object form is embedded, it will automatically be displayed
 * if the control is added without an object.
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality:
 * 
 * 	<ul>
 * 		<li>public HtmlContentForm form()</li>
 * 		<li>public HtmlContent obj([HtmlContent newValue])</li>
 * 		<li></li>
 * 		<li>[AJAX] public void add(string id, string objectId, string objectName, bool embedForm, string targetContainerId, function onAdd())</li>
 * 		<li>public void reset()</li>
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
class HtmlContentControl extends WigbiUIPlugin
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
	 * Add a HtmlContentControl to the page. 
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
	 * @param		bool		$embedForm		Whether or not to embed an HtmlContentForm; default false.
	 * @return	string								The resulting HTML, if any.
	 */
	public static function add($id, $objectOrId, $objectName, $embedForm = false)
	{
		$plugin = new HtmlContentControl($id);
		$formId = $id . "Form";
		$obj = new HtmlContent();
		$obj = $obj->loadOrInit($objectOrId, $objectName, "name");
		
		if (!$obj->name())
			$obj->name($objectName);
	
		$plugin->beginPlugin();
		$plugin->beginPluginDiv();
		if ($embedForm)
			$plugin->beginViewDiv($embedForm && $obj->id());
		
		View::addTextArea($plugin->getChildId("object"), json_encode($obj), "class='hide'");
		View::addDiv($plugin->getChildId("content"), $obj->content());
		
		if ($embedForm)
		{
			$plugin->endViewDiv();
			$plugin->beginEditDiv(!$obj->id());
			print HtmlContentForm::add($formId, $obj, "");
			$plugin->endEditDiv();	
		}
		?>

		<script type="text/javascript">
				<?php if ($embedForm) { ?>
					var <?print $formId ?> = new HtmlContentForm("<?print $formId ?>");
					var <?print $id ?> = new HtmlContentControl("<?print $id ?>", <?print $formId ?>);
				<?php } else { ?>
					var <?print $id ?> = new HtmlContentControl("<?print $id ?>");
				<?php } ?>
		</script>
		
		<?php
		$plugin->endPluginDiv();
		return $plugin->endPlugin();
	}
}

?>