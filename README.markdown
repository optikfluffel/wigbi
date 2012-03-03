Wigbi
=====

Author: [Daniel Saidi](daniel.saidi@gmail.com)

Wigbi is a minimalistic, open source PHP/JavaScript framework that helps you create web sites and web-based applications. It is quick to setup, easy to learn and can easily be extended with plugins as well as with your own classes.

The basic Wigbi release contains:

* ``controllers/``  - Basic controller setup and a home controller
* ``wigbi/`` - The latest Wigbi version
* ``plugins/`` - Wigbi data and UI plugins
* ``views/`` - A default home index view as well as a master page
* ``REMOVE_FILE_NAME.htaccess`` - A .htaccess file used by Wigbi MVC

The Wigbi unit tests are not part of the release bundle. Grab them by forking the source code at http://github.com/danielsaidi/wigbi


Getting started
===============

If you are using Wigbi for the first time, you should start off by having a look at the short video tutorial that is up at [wigbi.com](http://wigbi.com).

Wigbi does not require the MVC components, but since the home view that is included in the release by default helps you configure the framework, you should use it at least the first time you set it up.

So, first rename ``REMOVE_FILE_NAME.htaccess`` to ``.htaccess``. This file will then enable basic URL rewriting for the Wigbi MVC engine. The file may become hidden when you remove the file name, but you have knowledge about how to access hidden files, I am sure ;)

If you use Wigbi out of the box, renaming the ``.htaccess`` file makes it possible to visit the root folder in your browser (even when it has no default page) which displays a page that checks if Wigbi is properly configured.

If Wigbi is NOT properly setup (which it will not be from scratch), you will receive some instructions on how to set it up correctly.

All you have to do is to:

* open ``wigbi/config.ini	`` (auto-generated when Wigbi is started)
* enter a value for ``application.name``		(a name of your choice)
* enter a value for ``application.webRoot`` (the web site root URL)

If you use data plugins, you also need to enter the four DB config parameters, which tells Wigbi how to connect to the database where the data plugins will be persisted.   

That's it! If you reload the page, it should not throw any more of these annoying exceptions. The start page is simple, but I will do some more work on it...in due time :)


IMPORTANT
=========

In Wigbi 1.1.2, I have created a separate ``wigbi/.htaccess`` file for Wigbi sites that will run on servers that has magic quotes enabled. In these cases, replace ``.htaccess`` with ``NO_MAGIC_QUOTES.htaccess`` to make Wigbi disable magic quotes, which otherwise will mess up data that is sent through the Wigbi AJAX pipeline.

Earlier, Wigbi could not be used on servers that did not have this magic quote feature installed, since attempting to disable it made Wigbi crash. The magic quote disabling line had to be deleted from the ``.htaccess`` file for Wigbi to work.

With this new setup, you only have to use the line if you need it.


Contact & downloads
===================

You will always find the latest source code and releases at [GitHub](http://github.com/danielsaidi/wigbi)

If you feel like helping out, [contact me](daniel.saidi@gmail.com) or visit http://www.wigbi.com

Since no one has taken contact with me yet, I assume that I can be lazy and work in a slooow pace that fits me :)