<?php

$wigbi_test_config = array();

$wigbi_test_config["application"] = array();
$wigbi_test_config["application"]["name"] = "application";
$wigbi_test_config["application"]["webRoot"] = "/wigbi_dev/";

Wigbi::configuration(new ArrayBasedConfiguration($wigbi_test_config));
Wigbi::cache(new MemoryCache());
Wigbi::translator(new ArrayBasedTranslator($wigbi_test_config));

$wigbi_test_logger = new NonLogger();
Wigbi::logger($wigbi_test_logger);

?>