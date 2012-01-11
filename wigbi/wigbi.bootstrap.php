<?php

//By default, first configure Wigbi using a configuration file
$config = new FileBasedConfiguration($wigbi_globals["config_file"], new IniFileReader());
Wigbi::configuration($config);





?>