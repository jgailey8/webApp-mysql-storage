<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//$FileList = json_decode($_GET["FileList"]);
  // $FileList = unserialize($_GET["FileList"]);
$FileList = $_GET["FileList"];

$ParentFolder = $_GET["CurrentFolder"];
$msg = 'deleting files';
include 'config.php';
$mysqli = new mysqli("127.0.0.1", $username, $password, $db_name, 3306);

if ($mysqli->connect_errno)
{
    $msg[] += "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
foreach($FileList as $value)
{
    // $usr = json_decode($value);
    $sql = "Delete from Files where FileName='$value' and ParentFolder='$ParentFolder'";
    $mysqli->query($sql);
}
    
$json = array('Message' => $msg, 'Files' => $FileList, 'SQL' => $sql );

print json_encode($json);

$mysqli->close();

