<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
error_reporting(E_ALL);

$host = 'mysql:host=localhost;debname=biken_ministore;chartset=utf8';
$userName = 'root';
$passWord = 'poi98799';

$pdo = new PDO($host, $userName, $passWord);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>