<?php

//By default, first configure Wigbi using a configuration file
$wigbi_config = new FileBasedConfiguration($wigbi_globals["config_file"], new IniFileReader());
Wigbi::configuration($wigbi_config);

//By default, use a file cache that use the config file folder as cache target
$wigbi_cache = new FileCache(Wigbi::config()->get("folder", "cache"), new DirectoryHandler(), new FileHandler());
Wigbi::cache($wigbi_cache);



?>