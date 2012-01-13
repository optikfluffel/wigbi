<?php
/**
 * Wigbi.PHP.Controls.RssFeedEntryList class file.
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
 * The RssFeedEntryList control class.
 * 
 * This control can list entries from any RSS feed. It generates an
 * ul list that displays a linked title and the item description.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the SimplePie class (http://www.simplepie.org).
 * 
 * Since SimplePie is a PHP based class, this control does not have
 * a JavaScript item function like the ObjectList control. Instead,
 * it fully refreshes the control with AJAX.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * RssFeedEntryList : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string cssClass()</li>
 * 		<li>public string setCssClass(string newVal)</li>
 * 		<li>public string feedUrl()</li>
 * 		<li>public string setFeedUrl(string newVal)</li>
 * 		<li>public int maxCount()</li>
 * 		<li>public void setMaxCount(int newVal)</li>
 * 		<li>public int skipCount()</li>
 * 		<li>public void setSkipCount(int newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string feedUrl, int skipCount, int maxCount, string cssClass, string targetElementId, function onAdd)</li>
 * 		<li>[ASYNC] public static void refresh(string feedUrl, int skipCount, int maxCount, string cssClass, onRefresh)</li>
 * 	</ul>
 * 
 * The refresh function can be used to refresh the list. The function
 * parameters are optional. If some parameters are not defined, their
 * current values will be used.
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @link		http://www.simplepie.org
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.9
 * @version		0.99.2
 */
class RssFeedEntryList extends BaseControl
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
RssFeedEntryList = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
	},
	
	
	/* Properties *************/

	//Get/set the CSS class to apply the next time the control is refreshed
	cssClass: function() { return this.form().cssClass.value; },
	setCssClass: function(newVal) { this.form().cssClass.value = newVal; },

	//Get/set the feed URL to apply the next time the control is refreshed
	feedUrl: function() { return this.form().feedUrl.value; },
	setFeedUrl: function(newVal) { this.form().feedUrl.value = newVal; },
	
	//Get/set the max count to apply the next time the control is refreshed
	maxCount: function() { return JSON.decode(this.form().maxCount.value); },
	setMaxCount: function(newVal) { this.form().maxCount.value = newVal; },
	
	//Get/set the skip count to apply the next time the control is refreshed
	skipCount: function() { return JSON.decode(this.form().skipCount.value); },
	setSkipCount: function(newVal) { this.form().skipCount.value = newVal; },
	
	
	/* Functions **************/
	
	//Refresh the list; parameters are optional
	refresh: function(feedUrl, skipCount, maxCount, cssClass, onRefresh)
	{
		//Update object properties
		if (cssClass)
			this.setCssClass(cssClass);
		if (feedUrl)
			this.setFeedUrl(feedUrl);
		if (maxCount)
			this.setMaxCount(maxCount);
		if (skipCount)
			this.setSkipCount(skipCount);
			
		//Re-add the control
		RssFeedEntryList.add(this.controlId(), this.feedUrl(), this.skipCount(), this.maxCount(), this.cssClass(), this.controlId() + '-container', onRefresh);
	}
});


/* Static functions ********/

//Add a new control instance to the page with AJAX
RssFeedEntryList.add = function(controlId, feedUrl, skipCount, maxCount, cssClass, targetElementId, onAdd)
{
	Wigbi.executeFunction('RssFeedEntryList', null, 'add', [controlId, feedUrl, skipCount, maxCount, cssClass], function(result)
	{
		//Add, create and init the control
		$('#' + targetElementId).html(result);
		new RssFeedEntryList(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add an RssFeedEntryList control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId			The unique control ID.
	 * @param	string	$feedUrl			The url of the feed to display items from.
	 * @param	int		$skipCount			The number of items to skip before starting to retrieve items; default 0.
	 * @param	int		$maxCount			The max number of items to retrieve; default 10.
	 * @param	string	$cssClass			The max CSS class to apply to the list.
	 */
	public static function add($controlId, $feedUrl, $skipCount = 0, $maxCount = 10, $cssClass = "")
	{ ?>
		<div id="<?php print $controlId ?>-container">
			<?php BaseControl::openForm("RssFeedEntryList", $controlId); ?>
			
				<input type="hidden" name="feedUrl" value="<?php print $feedUrl; ?>" />
				<input type="hidden" name="skipCount" value="<?php print $skipCount; ?>" />
				<input type="hidden" name="maxCount" value="<?php print $maxCount; ?>" />
				<input type="hidden" name="cssClass" value="<?php print $cssClass; ?>" />
				
				<ul <?php print $cssClass ? "class='" . $cssClass . "'" : "" ?>>
					<?php
					
						//Init the feed
						$feed = new SimplePie();
						$feed->set_feed_url($feedUrl);
						$feed->init();
						
						//Get all feeds
						$i = 0;
						foreach($feed->get_items($skipCount, $maxCount) as $item)
						{
							//Setup css class
							$cssClass = "";
							if ($i % 2)
								$cssClass = " class='even'";
							
							//Generate the <li> item
							print '<li' . $cssClass . '><a href="'.$item->get_permalink().'">'.$item->get_title().'</a><br />'. "\n";
							print $item->get_description() . '</li>'."\n";
							
							//Increment counter
							$i = $i + 1;
						}
					?>
				</ul>
				
				<script type="text/javascript">
					new RssFeedEntryList("<?php print $controlId ?>");
				</script>
				
			<?php BaseControl::closeForm(); ?>
		</div>
	<?php }
}
?>