<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	include 'config.php';
	$mysqli = new mysqli("127.0.0.1", $username, $password, $db_name, 3306);
	if ($mysqli->connect_errno)
    {
    		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
        $username = $_POST['userName'];
        $password = $_POST['password'];

    if (isset($username, $password))
    {
        $sql = 'SELECT Name,Admin FROM `Users` WHERE UserName=? and Password=?';

        if ($stmt = $mysqli->prepare($sql))
        {
        // bind parameters for markers
        $stmt->bind_param("ss", $username,$password);
        
        // execute query
        $stmt->execute();
        // bind result variables
        $stmt->bind_result($name,$admin);

            if($stmt->fetch())
            {
                session_start();
                $_SESSION['login'] = TRUE;
                $_SESSION['Name'] = $name;
                $_SESSION['UserName'] = $username;
                $_SESSION['Admin'] = $admin;
                header("Location: index.php");
            }
            else
            {
                echo "incorrect login information";
            }
        }
    }

    $mysqli->close();
?>
