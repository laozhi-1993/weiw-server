<?php


include_once(dirname(__DIR__) . '/wwwroot/weiw/index.php');
include_once(__DIR__ . '/simple.php');
include_once(__DIR__ . '/process.php');
include_once(__DIR__ . '/process_manager.php');
include_once(__DIR__ . '/web_socket_client.php');
include_once(__DIR__ . '/web_socket_server.php');



$websocket = new web_socket_server('127.0.0.1', 9001);
$processmanager = new process_manager($websocket, dirname(__DIR__) . '/servers');
$processmanager ->start();


Simple::run();