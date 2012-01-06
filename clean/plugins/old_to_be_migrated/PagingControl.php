<?php
/**
 * Wigbi.PHP.Controls.PagingControl class file.
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
 * The PagingControl control class.
 * 
 * This control can be used to step through a collection of objects
 * of which only a few are listed.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * To use the control, simply add it to a page that features a list
 * of any kind, then override the onSelectedPageIndexChanged event,
 * so that it affects the list you want to modify.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * PagingControl : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public int pageCount()</li>
 * 		<li>public int pageMaxDisplayCount()</li>
 * 		<li>public int pageSize()</li>
 * 		<li>public int selectedPageIndex()</li>
 * 		<li>public void setSelectedPageIndex(string newVal)</li>
 * 		<li>public int skipCount()</li>
 * 		<li>public int totalCount()</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, int totalCount, int pageSize, int pageMaxDisplayCount, string targetElementId, function onAdd)</li>
 *		<li>private void buttonClick(buttonIndex)</li>
 *		<li>private void refreshPageLinks()</li>
 * 		<li>public void selectNextPage()</li>
 * 		<li>public void selectPage(int pageIndex)</li>
 * 		<li>public void selectPreviousPage()</li>
 * 	</ul>
 * 
 * Events:
 *	<ul>
 * 		<li>public void onSelectedPageIndexChanged()</li>
 * 	</ul>
 * 
 * Override the onSelectedPageChanged event to set what to do when
 * a page link is clicked. By default, it does nothing. This event
 * should affect a list of any kind, e.g. loading objects from the
 * database and adding them to an ObjectList control.
 * 
 * 
 * LANGUAGE HANDLING *************************
 * 
 * The following language parameters are used by the control:
 * 
 *	<ul>
 * 		<li>[controlId] PagingControl nextPage</li>
 * 		<li>[controlId] PagingControl previousPage</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.9
 * @version		0.99.2
 */
class PagingControl extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the control.
	 * 
	 * This constructor is only intended to be used by Wigbi at startup.
	 * 
	 * @access	public
	*/
	public function __construct()
	{
		//Register the general JavaScript
		$this->registerJavaScript(@"
PagingControl = Class({ Extends: BaseControl,
	
	/* Private variables ******/
	
	_selectedPageIndex: 0,
	_skipCount: 0,
	
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//By default, select the first page
		this.selectPage(0);
	},
	
	
	/* Properties *************/

	//Get the total number of pages that the control handles.
	pageCount: function() { return parseInt(this.form().pageCount.value); },
	
	//Get the max number of page links that will be displayed.
	pageMaxDisplayCount: function() { return parseInt(this.form().pageMaxDisplayCount.value); },
	
	//Get the max number of objects that are to be displayed per page.
	pageSize: function() { return parseInt(this.form().pageSize.value); },
	
	//Get/set the index of the currently selected page
	selectedPageIndex: function() { return this._selectedPageIndex; },
	setSelectedPageIndex: function(newVal) { this.selectPage(newVal); },
	
	//Get the skip count of the currently selected page
	skipCount: function() { return this._skipCount; },
	
	//Get the total amount of objects that are to be paged
	totalCount: function() { return parseInt(this.form().totalCount.value); },
	
	
	
	/* Functions **************/
	
	//Execute a certain button click
	buttonClick: function(buttonIndex)
	{
		this.selectPage(parseInt($('#' + this.controlId() + '-btn' + buttonIndex).text()) - 1);	
	},
	
	//Refresh the page links
	refreshPageLinks: function()
	{	
		//Calculate the start index
		var startIndex = Math.ceil(this.selectedPageIndex() - this.pageMaxDisplayCount() / 2);
		if (startIndex + this.pageMaxDisplayCount() > this.pageCount())
			startIndex = this.pageCount() - this.pageMaxDisplayCount();
		if (startIndex < 0)
			startIndex = 0;

		//Disable/enable previous button correctly
		var previousButton = $('#' + this.controlId() + '-btnPrevious');
		previousButton.removeClass('disabled');
		if (this.selectedPageIndex() == 0)
			previousButton.addClass('disabled');
			
		//Show/hide the previous dots correctly
		var previousDots = $('#' + this.controlId() + '-dotsPrevious');
		if (startIndex > 0)
			previousDots.show();
		else
			previousDots.hide();
	
		//Update page button texts
		for (var i=0; i<this.pageMaxDisplayCount(); i++)
		{
			var btn = $('#' + this.controlId() + '-btn' + i);
			btn.removeClass('selected').html(i + startIndex + 1);
			if (i + startIndex == this.selectedPageIndex())
				btn.addClass('selected').text(i + startIndex + 1).html('<u>' + btn.text() + '</u>');
		}
		
		
		//Show/hide the previous dots correctly
		var nextDots = $('#' + this.controlId() + '-dotsNext');
		if (startIndex + this.pageMaxDisplayCount() < this.pageCount())
			nextDots.show();
		else
			nextDots.hide();
		
		//Disable/enable next button correctly
		var nextButton = $('#' + this.controlId() + '-btnNext');
		nextButton.removeClass('disabled');
		if (this.selectedPageIndex() == this.pageCount() - 1)
			nextButton.addClass('disabled');
	},
	
	//Select a certain page, if applicable
	selectNextPage: function()
	{
		if (this.selectedPageIndex() == this.pageCount() - 1)
			return;
		this.selectPage(this.selectedPageIndex() + 1);
	},
	
	//Select a certain page
	selectPage: function(pageIndex)
	{
		//Limit the value
		if (pageIndex < 0)
			pageIndex = 0;
		if (pageIndex >= this.pageCount())
			pageIndex = this.pageCount() - 1;
		
		//Set the properties
		this._selectedPageIndex = pageIndex;
		this._skipCount = pageIndex * this.pageSize();	
		
		//Normalize the page links
		this.refreshPageLinks();
		
		//Raise the event
		this.onSelectedPageIndexChanged();
	},
	
	//Select a certain page, if applicable
	selectPreviousPage: function()
	{
		if (this.selectedPageIndex() == 0)
			return;
		this.selectPage(this.selectedPageIndex() - 1);
	},
	
	
	/* Events ***********/
	
	//Raised when the selected page index changes
	onSelectedPageIndexChanged: function() { }
});


/* Static functions ********/

//Add a new control instance to the page with AJAX
PagingControl.add = function(controlId, totalCount, pageSize, pageMaxDisplayCount, targetElementId, onAdd)
{
	Wigbi.executeFunction('PagingControl', null, 'add', [controlId, totalCount, pageSize, pageMaxDisplayCount], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new PagingControl(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a PagingControl control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId				The unique control ID.
	 * @param	int		$totalCount				The total amount of objects that are to be paged.
	 * @param	int		$pageSize				The max number of objects that are to be displayed per page.
	 * @param	int		$pageMaxDisplayCount	The max number of pages that the control will display before adding ...
	 */
	public static function add($controlId, $totalCount, $pageSize, $pageMaxDisplayCount)
	{
		//Calculate the total amount of pages
		$pageCount = 1;
		if ($totalCount != $pageSize && $pageSize != 0)
			$pageCount = ceil($totalCount / $pageSize);
			
		//Limit page max display count if needed
		if ($pageMaxDisplayCount > $pageCount)
			$pageMaxDisplayCount = $pageCount;
			
		//Abort if only 1 page
		if ($pageCount == 1 || $totalCount == 0)
			return;
		
		//Render the control
		BaseControl::openForm("PagingControl", $controlId);
		?>
			<input type="hidden" name="totalCount" value="<?php print $totalCount ?>" />
			<input type="hidden" name="pageMaxDisplayCount" value="<?php print $pageMaxDisplayCount ?>" />
			<input type="hidden" name="pageSize" value="<?php print $pageSize ?>" />
			<input type="hidden" name="pageCount" value="<?php print $pageCount ?>" />
			
			<a href="" onclick="Wigbi.getControl('<?php print $controlId ?>').selectPreviousPage(); return false;" id="<?php print $controlId ?>-btnPrevious" class="button previous"><?php print LanguageHandler::translate("$controlId PagingControl previousPage"); ?></a>
			<a href="" onclick="Wigbi.getControl('<?php print $controlId ?>').buttonClick(0); return false;" id="<?php print $controlId ?>-dotsPrevious" class="dots previous">...</a>
			
			<?php for ($i=0; $i<$pageMaxDisplayCount; $i++) { ?>
				<a href="" onclick="Wigbi.getControl('<?php print $controlId ?>').buttonClick(<?php print $i ?>); return false;" id="<?php print $controlId ?>-btn<?php print $i ?>" class="button page"><?php print $i + 1 ?></a>
			<?php } ?>
			
			<a href="" onclick="Wigbi.getControl('<?php print $controlId ?>').buttonClick(<?php print ($i-1); ?>); return false;" id="<?php print $controlId ?>-dotsNext" class="dots next">...</a>
			<a href="" onclick="Wigbi.getControl('<?php print $controlId ?>').selectNextPage(); return false;" id="<?php print $controlId ?>-btnNext" class="button next"><?php print LanguageHandler::translate("$controlId PagingControl nextPage"); ?></a>
			
			<script type="text/javascript">
				new PagingControl("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
}
?>