<?php

$wigbi_config = new FileBasedConfiguration($wigbi_globals["config_file"], new IniFileReader());
Wigbi::configuration($wigbi_config);

$wigbi_cache = new FileCache(Wigbi::configuration()->get("folder", "cache"), new DirectoryHandler(), new FileHandler());
Wigbi::cache($wigbi_cache);

$wigbi_translator = new FileBasedTranslator(Wigbi::serverRoot("wigbi/lang/en-en.ini"), new IniFileReader());
Wigbi::translator($wigbi_cache);

$wigbi_logging_logger_types = explode(",", Wigbi::configuration()->get("logger_types", "logging"));
$wigbi_logging_severities = explode(",", Wigbi::configuration()->get("severities", "logging"));
$wigbi_logging_destination = Wigbi::configuration()->get("destination", "logging");
$wigbi_logging_headers = Wigbi::configuration()->get("extra_headers", "logging");
$wigbi_logger = new SeverityLoggerDecorator(new ErrorLog($wigbi_logging_logger_types, $wigbi_logging_destination, $wigbi_logging_headers), $wigbi_logging_severities);
Wigbi::logger($wigbi_logger);

?>