Wigbi
=====

Author: Daniel Saidi [daniel.saidi@gmail.com]

Wigbi is a minimalistic, open source PHP/JavaScript framework that
helps you create web sites and web-based applications. It is quick
to setup, easy to learn and can easily be extended with plugins as
well as with your own classes.

A complete Wigbi release contains the following folders and files:

	* wigbi/		All folders/files that are needed to use Wigbi
	* plugins/		Fully working, basic Wigbi data and UI plugins
		
	* controllers/	A controller base class and default controller
	* views/		A default index view and a default master page
	* REMOVE_FILE_NAME.htaccess   .htaccess file, used for routing

The Wigbi unit tests are not part of the release bundle. Grab them
by forking the source code at http://github.com/danielsaidi/wigbi


Getting started
===============

If you are using Wigbi for the first time, you should start off by
having a look at the short video that is up at wigbi.com.

Wigbi does not need the controllers and views folders to work, but
they are a big convenience. First of all, the home index view is a
getting started view by default. It will show you what you have to
do to get Wigbi up and running. So, if you are new to using Wigbi,
at least save them until you know how to get Wigbi to work.

With this said, all you have to do to get Wigbi to work is:

	1.	Rename REMOVE_FILE_NAME.htaccess to .htaccess
		This will enable the default Wigbi routing. Edit this file
		to modify how Wigbi routes requests.
	
	2.	Navigate to the application root in a browser
		With the .htaccess file renamed and Wigbi routing in place,
		you should be taken to the controllers/homeController. The
		controller should load the views/home/index.php view.
		
	3.	Follow the instructions
		If Wigbi is not properly configured, you should see a help
		instruction that tells you what to do. It will (basically)
		tell you to:

		* open wigbi/config.ini
		* enter a value for application.name
		* enter a value for application.clientRoot  (the root URL)

		If you use data plugins, you must enter the four DB config
		parameters, which tells Wigbi how to connect to a database,
		where the data plugins will be persisted.   

That's it! If you reload the page, it should not throw any more of
these annoying exceptions.


IMPORTANT
=========

In Wigbi 1.1.2, I added a separate .htaccess file for servers that
has no support for magic quotes. Before this, Wigbi would not work
for such servers.

If your server does not support magic quotes, replace the original
wigbi/.htaccess file with the NO_MAGIC_QUOTES.htaccess file in the
wigbi/assets/htaccess/ folder.


Contact & downloads
===================

You will always find the latest source code and releases at GitHub:
http://github.com/danielsaidi/wigbi

If you feel like helping out, contact me at daniel.saidi@gmail.com
or visit http://www.wigbi.com

Since no one has taken contact with me yet, I assume that I can be
lazy and work in a slooow pace that fits me :)
