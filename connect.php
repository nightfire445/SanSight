<?php
$url = getenv('JAWSDB_MARIA_URL');
$dbparts = parse_url($url);

$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'],'/');

try {
    $dbconn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>