<?php

$host         = "localhost";
$username     = "root";
$password     = "";
$dbname       = "db_spperpus";

try {
    $dbconn = new PDO('mysql:host=localhost;dbname=db_spperpus', $username, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
