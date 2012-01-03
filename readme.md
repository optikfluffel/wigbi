Wigbi
=====

Wigbi is a minimalistic, open source PHP/JavaScript framework that
helps you create web sites and web-based applications.

Wigbi is quick to setup and easy to learn. It can be combined with
other frameworks and extended with plugins and your own classes.


Contact and resources
---------------------

	Author:		Daniel Saidi  [daniel.saidi@gmail.com]
	Site:		http://www.wigbi.com
	Project:	http://www.github.com/danielsaidi/wigbi


Downloading Wigbi
-----------------

You can either download Wigbi from the web or project site. A full
release contains the following files and folders:

	* wigbi/		All folders/files that are needed to use Wigbi
	* plugins/		Fully working, basic Wigbi data and UI plugins

	* controllers/	A controller base class and default controller
	* views/		A default index view and a default master page
	* REMOVE_FILE_NAME.htaccess   .htaccess stub, used for routing

For more stuff like unit tests etc, grab the source code at GitHub.


Getting started
---------------

If you use Wigbi for the first time, you should start with looking
at the short video that is up at wigbi.com.

Wigbi doesn't need the .htaccess file nor the controllers or views
folders, but they are a big convenience. Until you get the hang of
how to use Wigbi, look at how they are used to setup Wigbi.

With this said, all you have to do to get Wigbi to work (using the
files and folders mentioned above) is to:

	1.	Download and unzip the latest Wigbi release. Place it in a
		folder that you can navigate to in a browser. 
	
	2.	Rename REMOVE_FILE_NAME.htaccess to .htaccess. By renaming
		the file, you enable Wigbi MVC routing and will be able to
		load the start page.
	
	3.	Navigate to the application root in a browser. The routing
		should take you to the controllers/homeController and load
		the views/home/index.php view.
		
	4.	By default, the home index view tells you how to configure
		Wigbi. It will (basically) tell you to:

		* open wigbi/config.ini
		* enter a value for application.name (it should be unique)
		* enter a value for application.clientRoot  (the root URL)

		If you use data plugins, you must also enter data provider
		information. Use the templates. If not, you are good to go.   

That's it! If you reload the page, it should now say that Wigbi is
properly configured.


Demo
----

The starter site that is bundled with the release uses most of the
stuff that Wigbi contains, so it can be considered to be some kind
of demo, although maybe not that exciting.


IMPORTANT
---------

Wigbi 1.1.2 added a NO_MAGIC_QUOTES.htaccess file for servers that
has no support for magic quotes. Before this, Wigbi would not work
for such servers. If your server does not support magic quotes, do
replace the wigbi/.htaccess file with the NO_MAGIC_QUOTES.htaccess
file in the wigbi folder.


Contact & downloads
-------------------

You will always find the latest source code and releases at GitHub:
http://github.com/danielsaidi/wigbi

If you feel like helping out, contact me at daniel.saidi@gmail.com
or visit http://www.wigbi.com

Since no one has taken contact with me yet, I assume that I can be
lazy and work in a slooow pace that fits me :)
