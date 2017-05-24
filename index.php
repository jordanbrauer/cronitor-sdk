<?php

// Usage

require_once 'vendor/autoload.php';

$cronitor = new \Cronitor\Monitor('i8XGrq');

$cronitor->run();
$cronitor->complete();
// $cronitor->fail();
// $cronitor->pause(0);
