<?php
/**
 * Current version
 */
const VERSION = "v2.2.27 (2017-01-24)";
$timestamp_now = date('Y-m-d H:i:s');



/**
 * Error handling
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors

date_default_timezone_set("UTC");

require __DIR__ . "/vendor/autoload.php";


/**
 * Open the database file and catch the exception it it fails.
 */
try {
    $dsn = "sqlite:db.sqlite";
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Failed to connect to the database using DSN:<br>$dsn<br>";
    throw $e;
}



/**
 * All courses/labs and their configfile.
 */
//const VALID_LABS = [
$VALID_LABS = [
    "javascript1/lab1" => "config/javascript1/lab1.php",
    "javascript1/lab2" => "config/javascript1/lab2.php",
    "javascript1/lab3" => "config/javascript1/lab3.php",
    "javascript1/lab4" => "config/javascript1/lab4.php",
    "javascript1/lab5" => "config/javascript1/lab5.php",

    "python/lab1" => "config/python/lab1.php",
    "python/lab2" => "config/python/lab2.php",
    "python/lab3" => "config/python/lab3.php",
    "python/lab4" => "config/python/lab4.php",
    "python/lab5" => "config/python/lab5.php",
    "python/lab6" => "config/python/lab6.php",

    "oopython/lab1" => "config/oopython/lab1.php",
    "oopython/lab2" => "config/oopython/lab2.php",
    "oopython/lab3" => "config/oopython/lab3.php",
    "oopython/lab4" => "config/oopython/lab4.php",
    "oopython/lab5" => "config/oopython/lab5.php",

    "htmlphp/lab1" => "config/htmlphp/lab1.php",
    "htmlphp/lab2" => "config/htmlphp/lab2.php",
    "htmlphp/lab3" => "config/htmlphp/lab3.php",
    "htmlphp/lab4" => "config/htmlphp/lab4.php",
    "htmlphp/lab5" => "config/htmlphp/lab5.php",
    "htmlphp/sql1" => "config/sql/lab1.php",
    "htmlphp/sql2" => "config/sql/lab2.php",

    "oophp/lab1" => "config/oophp/lab1.php",

    "linux/bash1" => "config/linux/bash1.php",
    "linux/bash2" => "config/linux/bash2.php",
    "linux/node1" => "config/linux/node1.php",
    "linux/node2" => "config/linux/node2.php",
    "linux/node3" => "config/linux/node3.php",

    "webgl/lab1" => "config/webgl/lab1.php",
    "webgl/lab2" => "config/webgl/lab2.php",

    "dbjs/javascript1" => "config/dbjs/javascript1.php",
    "dbjs/javascript2" => "config/dbjs/javascript2.php",
    "dbjs/sql1" => "config/dbjs/sql1.php",

    "dbjs/lab2" => "config/dbjs/lab2.php",
    "dbjs/lab3" => "config/dbjs/lab3.php",
    "dbjs/lab4" => "config/dbjs/lab4.php",
    "dbjs/lab5" => "config/dbjs/lab5.php",
    "dbjs/lab6" => "config/dbjs/lab6.php",

];

// Type of lab
$LAB_TYPE = [
    "htmlphp"      => [
        "lab1" => "php",
        "lab2" => "php",
        "lab3" => "php",
        "lab4" => "php",
        "lab5" => "php",
        "sql1" => "sqlite",
        "sql2" => "sqlite",
    ],
    "oophp"      => "php",
    "javascript1" => "javascript",
    "webgl"      => "javascript",
    "python"     => "python",
    "oopython"   => "python",
    "dbjs" => [
        "javascript1" => "javascript",
        "javascript2" => "javascript",
        "sql1" => "bash",
    ],
    "linux"      => [
        "bash1" => "bash",
        "bash2" => "bash",
        "node1" => "node",
        "node2" => "node",
        "node3" => "node",
    ],
];
