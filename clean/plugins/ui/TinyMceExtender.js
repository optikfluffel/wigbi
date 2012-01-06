/**
 * Wigbi.Plugins.UI.TinyMceExtender JavaScript class file.
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
 * The Wigbi.Plugins.UI.TinyMceExtender JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function TinyMceExtender()
{
	//Inherit WigbiUIPlugin
	$.extend(this, new WigbiUIPlugin());
};


//The Tiny MCE extender script and css files - set by PHP
TinyMceExtender.cssFile = "";
TinyMceExtender.scriptFile = "";


//[AJAX] Apply Tiny MCE to the page.
TinyMceExtender.add = function()
{
	var plugins = "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist";
	var replaceValues = { username : "Some User", staffid : "991234" };
	var width = "100%"; 
	
	$().ready(function() {
		$('textarea.wysiwyg.simple').tinymce({
			script_url : TinyMceExtender.scriptFile,
			content_css : TinyMceExtender.cssFile,

			theme : "simple",
			plugins : plugins,
			width: width,

			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			template_replace_values : replaceValues
		});
		
		$('textarea.wysiwyg.slimmed').tinymce({
			script_url : TinyMceExtender.scriptFile,
			content_css : TinyMceExtender.cssFile,

			theme : "advanced",
			plugins : plugins,
			width: width,
			
			/* unused_buttons : abbr,absolute,acronym,advhr,backcolor,blockquote,cite,del,emotions,fontselect,fontsizeselect,help,iespell,ins,insertlayer,moveforward,movebackward,pagebreak,styleprops,template */ 
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,link,unlink,|,undo,redo,|,code",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			template_replace_values : replaceValues
		});
		
		$('textarea.wysiwyg.advanced').tinymce({
			script_url : TinyMceExtender.scriptFile,
			content_css : TinyMceExtender.cssFile,

			theme : "advanced",
			plugins : plugins,
			width: width,
			height: 350,
			
			/* unused_buttons : 
					styling (use css): 	backcolor, fontselect, fontsizeselect, styleprops
					div handling:				insertlayer, absolute, moveforward, movebackward
					elements:						advhr, attribs, nonbreaking, pagebreak, template
					misc:								emotions, help, iespell, preview, visualchars
			 */ 
			theme_advanced_buttons1 : "save,newdocument,print,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,forecolor,|,undo,redo,|,code,fullscreen",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,|,link,unlink,anchor,|,image,charmap,media,|,insertdate,inserttime,|,sub,sup,|,cleanup",
			theme_advanced_buttons3 : "tablecontrols,|,hr,visualaid,|,ltr,rtl,|,acronym,abbr,cite,blockquote,|,del,ins,|,removeformat",
			//theme_advanced_toolbar_location : "top",
			//theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : replaceValues
		});
	});
};