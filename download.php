<?php

$Filename = $_GET["FileName"];
$msg = array();
//$msg[] = "Downloading Files". $FileList ;
//$fileNames = array();
//$msg[] = "starting";

    include 'config.php';
    $mysqli = new mysqli("127.0.0.1", $username, $password, $db_name, 3306);
    
    if ($mysqli->connect_errno)
    {
        $msg[] += "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
       //Get FIle of Assignment 
    $sql = "Select * FROM Files 
        WHERE FileName='$Filename'";
    $results = $mysqli->query($sql);
    //$result = $mysqli->query($sql);
    if($row = $results->fetch_array())
    {
            //$File = array();
            $File[] = $row;
            //$filename = $row['FileName'];
            $Filename = $row['FileName'];
            $mimetype = $row['FileType'];
            $filedata = $row['FileData'];
            $size = $row['FileSize'];


        header("Content-length: $size");
        header("Content-type: $mimetype");
        //header("Content-Disposition: download; filename=$filedata");
        header("Content-Disposition: attachment; filename=".$Filename);
        echo $filedata; 
    }
    
//$json = array('Message' => $msg, 'Files' => $Filename);

//print json_encode($json);

$mysqli->close();
//print json_encode($_FILES['myFile']);
//print json_encode($json);

?>
