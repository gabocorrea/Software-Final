<?php
/* uploadFile.php
 * 
 * Receives from post 1 file, which should be a .csv file representing a CHi project. After upload,
 * the file is moved (in the server) from it's temp folder to the corresponding project folder, creating
 * folders to that path if needed.
 */
include "C:\Program Files\chromePHP\ChromePhp.php";

// ChromePhp::log("1");

error_reporting(E_ALL);
$CHiFolderName = 'CHi-files';

//header('Content-type: application/json'); //don't know what this line does, so i commented it

// ChromePhp::log("2");
$fileName = $_FILES['file']['name'];
// ChromePhp::log("3");


$ret = array();
$ret["success"] = 0;
$ret["successMsg"] = "Success uploading file";
// ChromePhp::log("4");

if ($_FILES['file']['error'] != 0)
{
	$ret["success"] = 1;
	$ret["successMsg"] = "unknown error uploading file";
// ChromePhp::log("5");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	//If folders haven't been created, create them 
	if (!file_exists(dirname('projects/'.$fileName.'/'.$CHiFolderName.'/project.csv')))
	{								
		mkdir(dirname('projects/'.$fileName.'/'.$CHiFolderName.'/project.csv'), 0777, true); //param true makes it recursive
	}

// ChromePhp::log("6");
	// Check if folder exists, just in case
	if (file_exists(dirname('projects/'.$fileName.'/'.$CHiFolderName.'/project.csv')))
	{
        if (move_uploaded_file($_FILES['file']['tmp_name'], 'projects/'.$fileName.'/'.$CHiFolderName.'/project.csv')) {
        } else {
			$ret["success"] = 2;
			$ret["successMsg"] = "Failed when moving the project file in server";
        }
	} else {
		$ret["success"] = 3;
		$ret["successMsg"] = "Failed to create folders for project in server";
	}

	echo json_encode($ret);
}


?>