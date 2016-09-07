<?php
include 'config.php';
$FolderName = $_POST["folderName"];
$mysqli = new mysqli("127.0.0.1", $username, $password, $db_name, 3306);
$userName = 'User';

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else
{
    $FolderList = array();

    //get all folders in Directory
if(empty($FolderName))
    $sql = "SELECT FolderName,UserName From Folder Where ParentFolder is NULL";
else
    $sql = "SELECT FolderName,UserName From Folder Where ParentFolder='$FolderName'";

if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_array())
        $FolderList[] = $row;
}
//get all files in Directory
if(empty($FolderName))
    $sql = "SELECT FileName,FileType,FileSize,FileDate From Files Where ParentFolder is NULL";
else
    $sql = "SELECT FileName,FileType,FileSize,FileDate From Files Where ParentFolder='$FolderName'";

$FileList = array();
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_array())
        $FileList[] = $row;
}
//get current directory path
//not the most efficient implementation
//bind paramater!
$path = array();
$sql = "call getPath('$FolderName');";
   // $mysqli->query($sql);
if ($result = $mysqli->query($sql)) 
{
    while ($row = $result->fetch_array())
        $path[] = $row[0];
       //print_r($row['folder']);
}

$json = array(
    'Files' => $FileList,
    'Folders' => $FolderList,
    'Path' => $path
);
print json_encode($json);
}

?>
