<?php

// Usage Examples

require_once "vendor/autoload.php";

use \Cronitor\Monitor;

$cronitor = new Monitor("monitor_id", [
  "base_url" => "https://cronitor.link",
  "auth_key" => "your_private_secret_confidential_auth_key",
]);

$cronitor->run(); // plain run ping
$cronitor->run("Hello Cronitor!"); // run ping with message

$cronitor->complete(); // plain complete ping
$cronitor->complete("Goodbye Cronitor!"); // complete ping with message

$cronitor->fail(); // plain fail ping
$cronitor->fail("Damn Cronitor!"); // fail ping with message

$cronitor->pause(1); // pause for 1 hour
$cronitor->start(); // resume monitoring
