<?php

$wigbi_config = new FileBasedConfiguration($wigbi_globals["config_file"], new IniFileReader());
Wigbi::configuration($wigbi_config);

$wigbi_cache = new FileCache(Wigbi::configuration()->get("cache", "folder", "cache"), new DirectoryHandler(), new FileHandler());
Wigbi::cache($wigbi_cache);

$wigbi_cookies = new Cookies(Wigbi::configuration()->get("application", "name"));
Wigbi::cookies($wigbi_cookies);

$wigbi_logging_logger_types = explode(",", Wigbi::configuration()->get("logging", "logger_types"));
$wigbi_logging_severities = explode(",", Wigbi::configuration()->get("logger_types", "severities"));
$wigbi_logging_destination = Wigbi::configuration()->get("logger_types", "destination");
$wigbi_logging_headers = Wigbi::configuration()->get("logger_types", "extra_headers");
$wigbi_logger = new SeverityLoggerDecorator(new ErrorLog($wigbi_logging_logger_types, $wigbi_logging_destination, $wigbi_logging_headers), $wigbi_logging_severities);
Wigbi::logger($wigbi_logger);

$wigbi_php_file_includer = new PhpFileIncluder();
Wigbi::phpFileIncluder($wigbi_php_file_includer);

$wigbi_session = new Session(Wigbi::configuration()->get("application", "name"));
Wigbi::session($wigbi_session);

$wigbi_translator = new FileBasedTranslator(Wigbi::serverRoot("wigbi/lang/en-en.ini"), new IniFileReader());
Wigbi::translator($wigbi_cache);

?>