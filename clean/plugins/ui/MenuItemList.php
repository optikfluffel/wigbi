<?php

/**
 * Wigbi.Plugins.UI.MenuItemList PHP class file.
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
 * The Wigbi.Plugins.UI.MenuItemList PHP class.
 * 
 * This plugin can be used to list all sub menu items that belong to
 * a certain menu item. It can also be used to add, edit, delete and
 * sort menu items, provided that the various parameters are enabled
 * when the list is added to the page.
 * 
 * Note that the plugin has no built-in functionality for adding and
 * editing menu items. Instead, it raises JavaScript events that can
 * be used to display a form with which the operation can be done.
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality:
 * 
 * 	<ul>
 * 		<li>public bool canAdd()</li>
 * 		<li>public bool canDelete()</li>
 * 		<li>public bool canEdit()</li>
 * 		<li>public bool canSort()</li>
 * 		<li>public string parentId()</li>
 * 		<li>public MenuItem parentItem()</li>
 * 		<li></li>
 * 		<li>[AJAX] public static add(string id, string parentObjectId, string parentObjectName, string cssClass, bool canAdd, bool canDelete, bool canEdit, bool canSort, string targetContainerId, function onAdd)</li>
 * 		<li>[AJAX] public void deleteListItem(string itemId)</li>
 * 		<li>[AJAX] public void moveListItem(string itemId, int numSteps)</li>
 * 		<li>[VIRTUAL] public void onAddClicked()</li>
 * 		<li>[VIRTUAL] public void onDeleteListItem(string itemId)</li>
 * 		<li>[VIRTUAL] public void onEditClicked(string itemId)</li>
 * 		<li>[VIRTUAL] public void onMoveListItem(string itemId, int numSteps)</li>
 * 		<li>[VIRTUAL] public void onReload()</li>
 * 		<li>[AJAX] public void reload()</li>
 * 	</ul>
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.UI
 * @version			1.0.2
 */
class MenuItemList extends WigbiUIPlugin
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
	 * Add a MenuItemList to the page. 
	 * 
	 * The $parentOrId parameter can either be an object instance or a
	 * unique object ID. If this parameter is set, set the $parentName
	 * parameter to an empty string and vice versa.
	 * 
	 * Various span elements are added to each li element depending on
	 * if they can be deleted, edited and/or sorted. If list items can
	 * be added, a separate ul is added after the main ul list. 
	 * 
	 * Note that sortable lists require the jQuery UI sortable plugin.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$parentOrId		The parent object or the ID of the parent to handle with the plugin.
	 * @param		string	$parentName		The name of the parent to handle with the plugin.
	 * @param		string	$cssClass			The css class(es) to add to the list ul element; default none.
	 * @param		bool		$canAdd				Whether or not it is possible to add items to the list; default false.
	 * @param		bool		$canDelete		Whether or not it is possible to delete items from the list; default false.
	 * @param		bool		$canEdit			Whether or not it is possible to edit items in the list; default false.
	 * @param		bool		$canSort			Whether or not it is possible to sort items in the list; default false.
	 */	 
	public static function add($id, $parentOrId, $parentName, $cssClass = "", $canAdd = false, $canDelete = false, $canEdit = false, $canSort = false)
	{
		$plugin = new MenuItemList($id);
		$obj = new MenuItem();
		$obj = $obj->loadOrInit($parentOrId, $parentName, "name");
		
		$children = $obj->getListItems("children");
		$children = $children[0];

		$plugin->beginPlugin();
		?>
		
		<input type="hidden" id="<?php print $plugin->getChildId("parentId") ?>" value="<?php print $obj->id() ?>" />
		<input type="hidden" id="<?php print $plugin->getChildId("canAdd") ?>" value="<?php print $canAdd ? 1 : "" ?>" />
		<input type="hidden" id="<?php print $plugin->getChildId("canDelete") ?>" value="<?php print $canDelete ? 1 : "" ?>" />
		<input type="hidden" id="<?php print $plugin->getChildId("canEdit") ?>" value="<?php print $canEdit ? 1 : "" ?>" />
		<input type="hidden" id="<?php print $plugin->getChildId("canSort") ?>" value="<?php print $canSort ? 1 : "" ?>" />
		<input type="hidden" id="<?php print $plugin->getChildId("cssClass") ?>" value="<?php print $cssClass ?>" />
		
		<div id="<?php print $id ?>-container">
			<ul id="<?php print $id ?>" class="<?php print $cssClass . ($canDelete ? " candelete" : "") . ($canEdit ? " canedit" : "") . ($canSort ? " cansort" : ""); ?>">		
				<?php foreach($children as $item) { ?>
					<li id="<?php print $item->id() ?>">
						<?php 	if ($canDelete || $canEdit || $canSort) { ?>
							<span class="box"></span>
						<?php } if ($canDelete) { ?>
							<span class="delete" onclick="<?php print $id ?>.deleteListItem('<?php print $item->id() ?>')"></span>
						<?php } if ($canEdit) { ?>
							<span class="edit" onclick="<?php print $id ?>.onEditClicked('<?php print $item->id() ?>')"></span>
						<?php } if ($canSort) { ?>
							<span class="move"></span>
						<?php } ?>
						<a href="<?php print (Wigbi::isAjaxPostBack() ? $item->url() : pwurl($item->url())) ?>" title="<?php print $item->tooltip() ?>"><?php print $item->text() ?></a>
					</li>
				<?php } ?>
			</ul>
			
			<?php if ($canAdd) { ?>
				<ul class="<?php print $cssClass . ($canAdd ? " canadd" : "") ?>">
					<li>
						<span><a href="" onclick="<?php print $id ?>.onAddClicked(); return false;">+</a></span>
					</li>
				</ul>
			<?php } ?>
		</div>
		
		<script type="text/javascript">
			var <?print $id ?> = new MenuItemList("<?print $id ?>");
		</script>
		
		<?php
		return $plugin->endPlugin();
	}
}

?>