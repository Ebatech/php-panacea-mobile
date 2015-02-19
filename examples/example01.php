<?php
require dirname(__FILE__).'/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

$p = new \phpPanaceaMobile\phpPanaceaMobile([
        "debug" => true,
        "apikey" => "YOUR-API-KEY",
        "thread" => "ThreadName",
]);

$p->send("DEVICE-ID", "Your Message Here.");

