<?php
/**
 * Wigbi.PHP.Controls.WigbiWizard class file.
 * 
 * Wigbi is free software. You can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *  
 * Wigbi Controls is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with Wigbi. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The WigbiWizard control class.
 * 
 * This control can be added to help developers start using Wigbi. It
 * will detect any errors and give advice on how to solve them.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * 
 * HOW TO USE THE CONTROL ********************
 * 
 * WigbiWizard : BaseControl
 * 
 * Functions:
 *	<ul>
 * 		<li>[AJAX] public static void add(string controlId, string targetElementId, function onAdd)</li>
 * 		<li>[AJAX] public void reload()</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.96
 * @version		0.99.3 
 */
class WigbiWizard extends BaseControl
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
WigbiWizard = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
	},
	
	
	/* Functions **************/
	
	//Reload the control
	reload: function()
	{
		WigbiWizard.add(this._controlId, this._controlId); 
	}
});


/* Static functions ********/

//Add a new control instance to the page
WigbiWizard.add = function(controlId, targetElementId, onAdd)
{
	Wigbi.executeFunction('WigbiWizard', null, 'add', [controlId], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new WigbiWizard(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a WigbiWizard control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId	The unique control ID.
	 * @return	bool				Whether or not Wigbi is correctly configured.
	 */
	public static function add($controlId)
	{
		?>
			<div id="<?php print $controlId ?>">
			<?php
			
				//Validation result
				$error = true;
			
				//File variables
				$configFile = is_file(Wigbi::serverRoot() . "wigbi/config.ini");
				$originalFile = is_file(Wigbi::serverRoot() . "wigbi/config_original.ini");
				$dbEnabled = Configuration::get("data.dbHost");
				$seeds = sizeof(Wigbi::seedClasses());
				$controls = sizeof(Wigbi::controlClasses());
				$seedScript = is_file(Wigbi::serverRoot() . "wigbi/js/system/wigbi_seeds.js");
				$controlScript = is_file(Wigbi::serverRoot() . "wigbi/js/system/wigbi_controls.js");

				
				/* wigbi/config_original.ini ******************* */
				if (!$originalFile && !$configFile) { ?>
					<h2>The Wigbi original configuration file is missing!</h2>
					<p>
						The original Wigbi config file - <i>wigbi/config_original.ini</i> -
						is missing. Without it, Wigbi can not generate the configuration
						file - <i>wigbi/config.ini</i>.
					</p>
					<p>
						If you can not re-add the file in any way, it is strongly adviced
						that you download the latest Wigbi release from
						<a href="http://www.wigbi.com">http://www.wigbi.com</a>	and start over.
					</p>
					<p>
						Make sure that <i>wigbi/config_original.ini</i> exists, then
						press the button below to proceed.	
					</p>
				<?php }
				
				
				/* wigbi/config.ini **************************** */
				else if (!$configFile) { ?>
					<h2>The Wigbi configuration file is missing!</h2>
					<p>
						The Wigbi config file - <i>wigbi/config.ini</i> - is missing.
						Without it, Wigbi can not be configured.
					</p>
					<p>
						Wigbi tries to create the config file automatically, using
						the <i>wigbi/config_original.ini</i> file as a template, but
						this does not seem to work.
					</p>
					<p>
						Is Wigbi missing write access to the <i>wigbi</i> folder? If so,
						either grant Wigbi write access or create the file manually. 
					</p>
					<p>
						Make sure that <i>wigbi/config.ini</i> exists, then
						press the button below to proceed.	
					</p>
				<?php }
				
				
				/* application.webRoot ************************* */
				else if (!Configuration::get("application.webRoot")) { ?>
					<h2>The application.webRoot parameter is not set!</h2>
					<p>
						You must set the <i>application.webRoot</i> parameter in the
						<i>wigbi/config.ini file</i>, otherwise you will not be able
						to use JavaScript, AJAX etc.
					</p>
					<p>
						The web root is the absolute path to the part of your app
						that will never change, no matter if you use URL rewriting.
						For instance, <i>http://localhost/any/folder/structure/application</i>
						should use <i>/any/folder/structure/application/</i>.	
					</p>
					<p>
						Make sure that the <i>application.webRoot</i> is set, then
						press the button below to proceed.	
					</p>
				<?php }
				
				
				/* application.name **************************** */
				else if (!Configuration::get("application.name")) { ?>
					<h2>The application.name parameter is not set!</h2>
					<p>
						You must set the <i>application.name</i> parameter in the
						<i>wigbi/config.ini file</i>, otherwise data may span over
						multiple applications. For instance, session variables and
						language files will be set for all applications with the same name.
					</p>
					<p>
						The application name should be a unique name for your application.
						Make sure that the <i>application.name</i> is set, then
						press the button below to proceed.	
					</p>
				<?php }
				
				
				/* data.* parameters *************************** */
				else if ($dbEnabled && !DbHandler::isConnected()) { ?>
					<h2>The data parameters are invalid!</h2>
					<p>
						You have defined a database server to connect to, but are not
						connected to a database, which means that the <i>data</i>
						parameters in the <i>wigbi/config.ini</i> file are probably invalid.
					</p>
					<p>
						You must set the <i>data.dbHost</i> and <i>data.dbName</i>
						parameter in the <i>wigbi/config.ini</i> file, together with
						the correct user name and password.
					</p>
					<p>
						Make sure that you either have valid or not database settings
						defined in the <i>wigbi/config.ini</i> file, then press the
						button below to proceed.	
					</p>
				<?php }
				
				
				/* data.* parameters *************************** */
				else if (DbHandler::isConnected() && !DbHandler::databaseExists()) { ?>
					<h2>The defined database does not exist!</h2>
					<p>
						You have defined a database server to connect to, but the
						database does not exist, which means that your database
						server user does not have the right to create a database.
					</p>
					<p>
						You must login to the database server with a user that has
						the right to create databases. If no database is created,
						either try to login with a user that has the right to create
						database or create one manually. 
					</p>
					<p>
						Make sure that the database exists, then press the button
						below to proceed.	
					</p>
				<?php }
				
				
				/* Seeds without a database ******************** */
				else if (!$dbEnabled && $seeds) { ?>
					<h2>You are using seeds without a database connection!</h2>
					<p>
						You are using seeds, but have not defined a database server
						to connect to. Seeds require a working database connection.
					</p>
					<p>
						You must set the <i>data.dbHost</i> and <i>data.dbName</i>
						parameter in the <i>wigbi/config.ini</i> file, together with
						the correct user name and password, to establish a working
						database connection.
					</p>
					<p>
						Make sure that you have valid database settings defined in
						the <i>wigbi/config.ini</i> file, then press the button below
						to proceed.	
					</p>
				<?php }
				
				
				/* Seeds without a script class file *********** */
				else if ($seeds && !$seedScript) { ?>
					<h2>You are using seeds, but no JavaScript class file exists!</h2>
					<p>
						You are using seeds, but Wigbi has not been able to create
						the JavaScript seed class file - <i>wigbi/js/system/wigbi_seeds.js</i>.
					</p>
					<p>
						This means that Wigbi probably does not have write access
						to the folder, which it requires. You must either grant
						Wigbi write access or find a way to generate the file manually.
					</p>
					<p>
						Make sure that the file exists, then press the button below
						to proceed.	
					</p>
				<?php }
				

				/* Controls without a script class file ******** */
				else if ($controls && !$controlScript) { ?>
					<h2>You are using controls, but no JavaScript class file exists!</h2>
					<p>
						You are using controls, but Wigbi has not been able to create
						the JavaScript control class file - <i>wigbi/js/system/wigbi_controls.js</i>.
					</p>
					<p>
						This means that Wigbi probably does not have write access
						to the folder, which it requires. You must either grant
						Wigbi write access or find a way to generate the file manually.
					</p>
					<p>
						Make sure that the file exists, then press the button below
						to proceed.	
					</p>
				<?php }
				
				
				//SUCCESS (FOR NOW) *******************************
				
				//Invalid database settings
				else
				{
					$error = false;
				?>
					<h2>Wigbi is properly configured!</h2>
					<p>
						The most critical Wigbi configuration parameters are
						correctly set, and Wigbi has write access to both the
						database and the wigbi folder (or at least, you found
						a way to get around any such restrictions).
					</p>
					<p>
						If any invalid settings that can only be detected in
						JavaScript are detected, you will be notified about
						any such errors in an alert window.
					</p>
					<p>
						Remove this control from the page if you do not need
						it anymore, or keep it in case you want to verify that
						Wigbi is working correctly later on as well.
					</p>
				<?php } 
				
				
				/* Add proceed button if an error arised */
				if ($error) { ?>
					<div style="text-align:right; background: #f0f0f0; border-top: solid 1px #999999; padding: 10px; margin-top: 10px;">
						<button onclick="try { Wigbi.getControl('<?php print $controlId ?>').reload(); } catch(e) { location.reload(); }">Proceed >></button>				
					</div>
				<?php } ?>
								
				<script type="text/javascript">
					
					//Set the error message
					var webRootSet = '<?php print Configuration::get("application.webRoot"); ?>' != "";
					var errorMessage = "The JavaScript library have not been loaded correcty. This could mean that the application.webRoot parameter in wigbi/config.ini is incorrectly set. Make sure that it is correctly set and press OK to reload the page!";
					
					//Try to add the control
					if (webRootSet)
					{
						try
						{
							new WigbiWizard("<?php print $controlId ?>", <?php print $error ? 1 : 0 ?>);	
						}
						catch(e)
						{
							alert(errorMessage);
							location.reload();
						}	
					}

				</script>

			</div>
		<?php
		
		//Return the result
		if (!Wigbi::isAsyncPostBack())
			return $error;
	}
	
	/**
	 * Verify whether or Wigbi is properly configured.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	bool	Whether or not Wigbi is correctly configured.
	 */
	public static function validate()
	{
		ob_start();
		$result = !WigbiWizard::add("");
		ob_get_clean();
		return $result;
	}
}
?>