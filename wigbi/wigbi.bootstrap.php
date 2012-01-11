<?php

//By default, first configure Wigbi using a configuration file
$wigbi_config = new FileBasedConfiguration($wigbi_globals["config_file"], new IniFileReader());
Wigbi::configuration($wigbi_config);

//By default, use a file cache that use the config file cache folder as cache target
$wigbi_cache = new FileCache(Wigbi::configuration()->get("folder", "cache"), new DirectoryHandler(), new FileHandler());
Wigbi::cache($wigbi_cache);

//By default, use a file based translator that use the config file language file as source
$wigbi_translator = new FileBasedTranslator(Wigbi::serverRoot("wigbi/lang/en-en.ini"), new IniFileReader());
Wigbi::translator($wigbi_cache);


?>