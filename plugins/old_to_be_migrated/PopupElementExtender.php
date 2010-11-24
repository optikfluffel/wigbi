<?php
/**
 * Wigbi.PHP.Controls.PopupElementExtender class file.
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
 * The PopupElementExtender extender class.
 * 
 * This extender can be used to convert DOM elements into popupable
 * elements, so that they can be used like popup windows.
 * 
 * The extender can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * The background is added behind the popup and above the page. This
 * restricts page interaction until the popup is closed. It can have
 * a color ('#abc123', 'red' etc.) or a file url, as well as opacity.
 * 
 * The control uses fixed positions to center the popup element. For
 * this to work in IE7, a doctype MUST be specified. Also, since IE6
 * does not support fixed positioning, the control will use absolute
 * positioning for IE6, but it does not reposition the popup.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * PopupElementExtender : BaseControl
 * 
 * Properties:
 * 	<ul>
 * 		<li>public string background()</li>
 * 		<li>public void setBackground(string newVal)</li>
 * 		<li>public string elementId()</li>
 * 		<li>public int height()</li>
 * 		<li>public void setHeight(int newVal)</li>
 * 		<li>public bool isOpen()</li>
 * 		<li>public int opacity()</li>
 * 		<li>public void setOpacity(int newVal)</li>
 * 		<li>public int width()</li>
 * 		<li>public void setWidth(int newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>public static void add(string controlId, string elementId, int width, int height, string background, int opacity)</li>
 * 		<li>public void close()</li>
 * 		<li>public void open()</li>
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
class PopupElementExtender extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the extender.
	 * 
	 * This constructor is only intended to be used by Wigbi at startup.
	 * 
	 * @access	public
	 */
	public function __construct()
	{
		//Register the general JavaScript control code
		$this->registerJavaScript(@"
var PopupElementExtender = new Class({ Extends: BaseControl,
	
	/* Private variables ******/
	
	_background : '',
	_elementId : '',
	_height : 100,
	_opacity : 50,
	_width : 100,
		
	
	/* Constructor ************/
	
	// Create an instance of the class.
	initialize: function(controlId, elementId, width, height, background, opacity)
	{
		//Call base contructor
		this.parent(controlId);
		
        //Init variables
		var _this = this;
        this._background = background;
        this._height = height;
        this._opacity = opacity;
        this._elementId = elementId;
        this._width = width;
		
		//Add bg element if needed
        if (!document.getElementById(this.controlId() + '_bg'))
		{
			//Create bg element
	        var bg = document.createElement('DIV');
	        bg.id = this.controlId() + '_bg';
			
			//Get the parent node
			var element = document.getElementById(this.elementId());
			var parent = element.parentNode;
		    if (parent.lastchild == element) parent.appendChild(bg);
			else parent.insertBefore(bg, element.nextSibling);
		}

		//Initially hide the element
		$('#' + elementId).hide();
		$('#' + this.controlId() + '_bg').hide();
		
		//Add window escape key event
		$(document).keypress(function(e)
		{
			if ($('#' + elementId).css('opacity') > 0 && e.keyCode == 27)
			{
				_this.close();
			}
		});
	},
	
	
	/* Properties *************/
	
	// Get/set the background color/image
	background: function() { return this._background; },
	setBackground: function(newVal)
	{
		this._background = newVal;
		this.refresh();
	},
	
	//Get the popup elementId
	elementId: function() { return this._elementId; },
	
	//Get/set the popup height
	height: function() { return this._height; },
	setHeight: function(newVal)
	{
		this._height = newVal;
		this.refresh();
	},
	
	//Get/set whether or not the popup element is open
	isOpen: function()
	{
		return $('#' + this.controlId() + '_bg').css('opacity') > 0;
	},
	
	//Get/set the background opacity
	opacity: function()
	{
		if (!this._opacity)
			return 50;
		return this._opacity;
	},
	setOpacity: function(newVal)
	{
		this._opacity = newVal;
		this.refresh();
	},
	
	//Get/set the popup width
	width: function() { return this._width; },
	setWidth: function(newVal)
	{
		this._width = newVal;	
		this.refresh();
	},
	
	
	/* Functions **************/
	
	//Close the popup element
	close : function()
    {
		$('#' + this.elementId()).fadeOut();
		$('#' + this.controlId() + '_bg').fadeOut();
    },
   
	//Open the popup element
    open : function()
    {
		//Set private var
		var _this = this;
		
		//Get elements and initially hide them
		var el = $('#' + this.elementId());
        var bg = $('#' + this.controlId() + '_bg').css('opacity', 0).hide();
		
		//Refresh
		this.refresh();
		
		//Add bg click event
		bg.unbind('click').click(function() { _this.close(); });
		
		//Hide the elements, then fade in
		bg.show().fadeTo('normal', this.opacity() / 100);
		el.fadeIn();
    },
	
	//Refresh the extender
	refresh: function()
	{
		//Get elements and initially hide them
		var el = $('#' + this.elementId());
        var bg = $('#' + this.controlId() + '_bg');
		
		//Set correct positioning (absolute for IE6)
		var position = 'fixed';
		if (window.ActiveXObject && !window.XMLHttpRequest)
			position = 'absolute';
		
		//Set correct background
		var background = this.background();
        if (!background) background = 'none';
        if (background.indexOf('.') > -1) background = 'url(' + background + ')';
		
		//Setup the target element
        el.css('position', position).css('zIndex', 10000);
        el.css('width', this.width() + 'px').css('height', this.height() + 'px');
        el.css('marginTop', -(this.height()/2) + 'px').css('marginLeft', -(this.width()/2) + 'px');
		el.css('top', '50%').css('left', '50%');

		//Setup the background
		bg.css('position', position).css('zIndex', 9999);
		bg.css('width', '100%').css('height', '100%');
        bg.css('top', '0px').css('left', '0px');
		bg.css('background', background);
		
		//Adjust the background opacity if the control is open
		if (this.isOpen())
			bg.fadeTo('normal', this.opacity() / 100);
	}
});

//Add a new extender instance to the page
PopupElementExtender.add = function(controlId, elementId, width, height, background, opacity)
{
	new PopupElementExtender(controlId, elementId, width, height, background, opacity);
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a PopupElementExtender extender to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId	The ID of the control.
	 * @param	string	$elementId	The ID of the target element.
	 * @param	int		$width		The popup element width.
	 * @param	int		$height		The popup element height.
	 * @param	string	$background	The background to use; either a color or a file url.
	 * @param	int		$opacity	The opacity percentage; default 50.
	 */
	public static function add($controlId, $elementId, $width = 100, $height = 100, $background = "", $opacity = 50)
	{
		?><script type="text/javascript">
			PopupElementExtender.add('<?php print $controlId; ?>', '<?php print $elementId; ?>' , <?php print $width; ?>, <?php print $height; ?>, '<?php print $background; ?>', <?php print $opacity; ?>);
		</script><?php
	}
}
?>