<?php
/**
 * Wigbi.PHP.Controls.TextHighlightExtender class file.
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
 * The TextHighlightExtender extender class.
 * 
 * This extender can be used to highlight certain words within a div,
 * span etc. The text is marked with a custom css class, which makes
 * it possible to fully customize the style of the highlighted text.
 * 
 * The extender can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * Note that the extender will not remove any highlighting that were
 * not applied by the extender itself. So, if you apply the extender
 * and after that change the text to one that contains highlighting,
 * the extender will not remove that highlighting. 
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * TextHighlightExtender : BaseControl
 * 
 * Properties:
 * 	<ul>
 * 		<li>public bool caseInsensitive()</li>
 * 		<li>public void setCaseInsensitive(bool newVal)</li>
 * 		<li>public string cssClass()</li>
 * 		<li>public void setCssClass(string newVal)</li>
 * 		<li>public string elementId()</li>
 * 		<li>public string[] words()</li>
 * 		<li>public void setWords(string[] newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>public static void add(string controlId, string elementId, string[] words, string cssClass, bool caseInsensitive)</li>
 * 		<li>public void highlight(string[] words, string cssClass, bool caseInsensitive)</li>
 * 		<li>public void refresh()</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.99.2
 * @version		0.99.2
 * 
 * @todo	Make a regexp and an option that makes the extender match complete words only 
 */
class TextHighlightExtender extends BaseControl
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
		$this->registerJavaScript(@'
var TextHighlightExtender = new Class({ Extends: BaseControl,
	
	/* Private variables ******/
	
	_caseInsensitive : true,
	_cssClass : "",
	_elementId : "",
	_originalString : "",
	_replacedString : "",
	_words : [],
		
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId, elementId, words, cssClass, caseInsensitive)
	{
		//Call base contructor
		this.parent(controlId);
		
        //Init variables
		var _this = this;
		this._caseInsensitive = caseInsensitive;
        this._cssClass = cssClass;
        this._elementId = elementId;
        this._words = words;
		
		//Refresh the control
		this.refresh();
	},
	
	
	/* Properties *************/
	
	//Get/set whether or not the highlight should be case insensitive
	caseInsensitive: function() { return this._caseInsensitive; },
	setCaseInsensitive: function(newVal) { this._caseInsensitive = newVal; },
	
	//Get/set the css class to apply to all highlighted words
	cssClass: function() { return this._cssClass; },
	setCssClass: function(newVal) { this._cssClass = newVal; },
	
	//Get the popup elementId
	elementId: function() { return this._elementId; },
	
	//Get/set the words to highlight
	words: function() { return this._words; },
	setWords: function(newVal) { this._words = newVal; },
	
	
	/* Functions **************/
	
	//Highlight certain words in the element with a certain css class
	highlight: function(words, cssClass, caseInsensitive)
	{
		//Get the element
		var element = $("#" + this.elementId());
		
		//Restore original string if it is still used, else apply the current one
		if (element.html() == this._replacedString)
			element.html(this._originalString);
		this._originalString = element.html();

		//Perform highlighting
		for (var i=0; i<words.length; i++)
		{	
			var regex = new RegExp("(<[^>]*>)|(\\\\b" + words[i].replace(/([-.*+?^${}()|[\\]\\/\\\\])/g,"\\\\$1") +")", caseInsensitive ? "ig" : "g");
			element.html(element.html().replace(regex, function(a, b, c) {
				return (a.charAt(0) == "<") ? a : "<span class=\'" + cssClass + "\'>" + c + "</span>"; 
			}));
		}
		
		//Catch replaced string
		this._replacedString = element.html();
	},
	
	//Refresh the extender highlighting
	refresh: function()
	{
		this.highlight(this.words(), this.cssClass(), this.caseInsensitive());
	}
});

//Add a new extender instance to the page
TextHighlightExtender.add = function(controlId, elementId, words, cssClass, caseInsensitive)
{
	new TextHighlightExtender(controlId, elementId, words, cssClass, caseInsensitive);
};
');
	}
	
	
	//Functions ********************
	
	/**
	 * Add a TextHighlightExtender extender to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId			The ID of the control.
	 * @param	string	$elementId			The ID of the target element.
	 * @param	array	$words				A list of words to highlight.
	 * @param	string	$cssClass			The CSS class to use for highlighting.
	 * @param	bool	$caseInsensitive	Whether or not to use case insensitive word matching.
	 */
	public static function add($controlId, $elementId, $words, $cssClass, $caseInsensitive)
	{
		?><script type="text/javascript">
			TextHighlightExtender.add("<?php print $controlId; ?>", "<?php print $elementId; ?>", <?php print json_encode($words); ?>, "<?php print $cssClass; ?>", <?php print ($caseInsensitive ? 1 : 0); ?>);
		</script><?php
	}
}
?>