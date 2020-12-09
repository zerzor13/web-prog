<?php
session_start();
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DBNAME", "gbook");
define("CHARSET", "utf8");
define("SALT", "PoLiTeHSILA");

$dsn = "mysql:host=" . HOST . "; dbname=" . DBNAME . ";charset=" . CHARSET;
try
{
    $dbConn = new PDO($dsn, USER, PASSWORD);
}
catch(PDOException $e)
{
    die('Підключення не вдалося: ' . $e->getMessage());
}

