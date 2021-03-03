<?php

function OpenCon()
 {
 $dbhost = "remotemysql.com";
 $dbuser = "8hwqgMaYLb";
 $dbpass = "B3bHSPBS9o";
 $db = "8hwqgMaYLb";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 
 return $conn;
 }

function CloseCon($conn)
{
    $conn -> close();
}

?>