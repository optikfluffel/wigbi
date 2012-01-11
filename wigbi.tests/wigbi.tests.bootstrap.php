<?php

$wigbi_test_config = array();

$wigbi_test_config["application"] = array();
$wigbi_test_config["application"]["name"] = "application";
$wigbi_test_config["application"]["webRoot"] = "/wigbi_dev/";

$wigbi_test_config["cache"] = array();
$wigbi_test_config["cache"]["folder"] = "/cache/";

$wigbi_test_config["language"] = array();
$wigbi_test_config["language"]["file"] = "/lang/en.ini";


Wigbi::configuration(new ArrayBasedConfiguration($wigbi_test_config));
Wigbi::cache(new MemoryCache());
Wigbi::translator(new ArrayBasedTranslator($wigbi_test_config));



?>