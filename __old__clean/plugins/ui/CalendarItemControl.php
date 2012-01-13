<?php

/**
 * Wigbi.Plugins.UI.CalendarItemControl PHP class file.
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
 * The Wigbi.Plugins.UI.CalendarItemControl PHP class.
 * 
 * This plugin can be used to display any CalendarItem object. It can
 * also be set to embed a form, with which new objects can be created
 * or already existing ones can be saved.
 * 
 * If the plugin is added with an embedded form, and no object is set
 * to be handled by the plugin, the form is automatically displayed.
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality:
 * 
 * 	<ul>
 * 		<li>[AJAX] public void add(string id, mixed object, bool embedForm, string targetContainerId, function onAdd())</li>
 * 		<li>[AJAX] public void setObject(CalendarItem object)</li>
 * 		<li>[AJAX] public void submit()</li>
 * 		<li></li>
 * 		<li>[VIRTUAL] public void onSubmit(CalendarItem obj)</li>
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
class CalendarItemControl extends WigbiUIPlugin
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
	 * Add a CalendarItemControl to the page.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$objectOrId		The object or the ID of the object to load into the form.
	 * @param		bool		$embedForm		Whether or not to embed a form; default false.
	 */
	public static function add($id, $objectOrId, $embedForm = false)
	{
		$obj = new CalendarItem();
		$obj = $obj->loadOrInit($objectOrId, "", "");
		
		$plugin = new CalendarItemControl($id);
		$plugin->beginPlugin();
		$plugin->beginPluginDiv();
		
		if (!$obj->startDateTime())
			$obj->startDateTime(date($plugin->translate("dateFormat")));
		if (!$obj->endDateTime())
			$obj->endDateTime(date($plugin->translate("dateFormat")));
		
		
		if ($embedForm)
			$plugin->beginViewDiv($embedForm && $obj->id()); ?>
		<input type="hidden" id="<?php print $plugin->getChildId("idInput") ?>" value="<?php print $obj->id() ?>" />
		
		
		<?php /* View area ********** */ ?>
		<h2 id="<?php print $plugin->getChildId("title"); ?>" class="title"><?php print $obj->title(); ?></h2>
		<div id="<?php print $plugin->getChildId("description"); ?>">
			<?php pwurl($obj->description()); ?>
		</div> 
		

		<?php /* Form area ********** */
		if ($embedForm)
		{
			$plugin->endViewDiv();
			$plugin->beginEditDiv($embedForm && !$obj->id()); ?>
		
			<form id="<?php print $plugin->getChildId("form") ?>">
				<div class="input-title title"><?php print $plugin->translate("title") ?>:</div>
				<div class="input title"><input type="text" id="<?php print $plugin->getChildId("titleInput") ?>" value="<?php print $obj->title() ?>" /></div>
				
				<div class="input-title startDateTime"><?php print $plugin->translate("date") ?>:</div>
				<div class="input startDateTime date">
					<input type="text" id="<?php print $plugin->getChildId("startDateTimeInput") ?>" value="<?php print $obj->startDateTime() ?>" />
					<input type="checkbox" id="<?php print $plugin->getChildId("fullDayInput") ?>" <?php print $obj->fullDay() ? 'checked="checked"' : "" ?> /> <?php print $plugin->translate("fullDay") ?>
				</div>
				
				<div id="<?php print $plugin->getChildId("endDateTimeDiv") ?>" class="<?php print $obj->fullDay() ? 'hide' : '' ?>"> 
					<div class="input-title endDateTime"><?php print $plugin->translate("endDate") ?>:</div>
					<div class="input endDateTime date">
						<input type="text" id="<?php print $plugin->getChildId("endDateTimeInput") ?>" value="<?php print $obj->endDateTime() ?>" />
					</div>
				</div>
				
				<div class="input-title description"><?php print $plugin->translate("description") ?>:</div>
				<div class="input description"><textarea id="<?php print $plugin->getChildId("descriptionInput") ?>" class="wysiwyg slimmed"><?php print $obj->description() ?></textarea></div>
				
				<div class="formButtons">
					<input type="reset" id="<?php print $plugin->getChildId("reset") ?>"  value="<?php print $plugin->translate("reset") ?>" />
					<input type="submit" id="<?php print $plugin->getChildId("submit") ?>"  value="<?php print $plugin->translate("submit") ?>" />
				</div>
			</form>
			
			<?php
			$plugin->endEditDiv();	
		} ?>
			
		<script type="text/javascript">
			var <?print $id ?> = new CalendarItemControl("<?print $id ?>");
		</script>
		
		<?php
		$plugin->endPluginDiv();
		return $plugin->endPlugin();
	}
}

?>