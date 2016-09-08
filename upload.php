<?php
$msg = array();
$fileNames = array();

    include 'config.php';
    $mysqli = new mysqli("127.0.0.1", $username, $password, $db_name, 3306);
    $curFolder = $_POST['Folder'];
    if ($mysqli->connect_errno)
    {
        $msg[] += "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    
    if ($_FILES['myFile']['error'][0] === UPLOAD_ERR_OK )
    {
        $fileCount = count($_FILES['myFile']['error']);
        // $curFolder = $_Files['currentFolder'];
        //go through files
        for ($i=0; $i<$fileCount; $i++) 
        {
            
            $fileName = $mysqli->real_escape_string($_FILES['myFile']['name'][$i]);
            $mime = $mysqli->real_escape_string($_FILES['myFile']['type'][$i]);
            $data = $mysqli->real_escape_string(file_get_contents($_FILES  ['myFile']['tmp_name'][$i]));
            $size = intval($_FILES['myFile']['size'][$i]);
            $fileNames[$i] = $_FILES['myFile']['name'][$i];
            //print json_encode($msg[$i]);
            
        if(empty($curFolder)
        {
            $sql = "INSERT INTO Files (FileName, FileType, FileSize, FileData,ParentFolder) 
            VALUES (?, '$mime' , '$size' ,'$data', NULL )";
        }
        else
        {
            $sql = "INSERT INTO Files (FileName, FileType, FileSize, FileData,ParentFolder) 
            VALUES (?, '$mime' , '$size' ,'$data', '$curFolder' )";
        }
        // $sql = "INSERT INTO Files (FileName, FileType, FileSize, FileData,ParentFolder) 
        //     VALUES (?, '$mime' , '$size' ,'$data', 'Jared' )";
        
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s",$fileName);
        //$stmt->bind_param("ssssi",$fileName,$assignmentType,$dueDate,$mime,$size);
    
            if($stmt->execute())
            {
                $msg[] = "Successfully uploaded File:";// + fileNames[$i];
            }
            // Execute the query
            else
                $msg[] = "ERROR: uploading File:";// + fileNames[$i];  
        }
    }
    else
        $msg[]='No files sent for upload';

//for debugging    
$json = array('Message' => $_POST, 'Files' => $fileNames, 'ParentFolder' => $curFolder);
print json_encode($json);

?>
