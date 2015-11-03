<?php
/* uploadFile.php
 * 
 * Receives from post 1 file, which should be a .chi file representing a CHi project. After upload,
 * the file is moved (in the server) from it's temp folder to the corresponding project folder, creating
 * folders to that path if needed.
 */
include "C:\Program Files\chromePHP\ChromePhp.php";
// ChromePhp::log("1");

//header('Content-type: application/json'); //don't know what this line does, so i commented it

//error_reporting(E_ALL);
$CHiFolderName = 'CHi-files';

$fileName = $_FILES['fileUploaded']['name'];
$fileName = pathinfo($fileName)['filename'];

$ret = array();
$ret["success"] = 0;
$ret["successMsg"] = "Success uploading file";

if ($_FILES['fileUploaded']['error'] != 0)
{
	$ret["success"] = 1;
	$ret["successMsg"] = "unknown error uploading file";
}


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	//If folders haven't been created, create them 
	if (!file_exists(dirname('projects/'.$fileName.'/'.$CHiFolderName.'/'.$fileName.'.chi')))
	{								
		mkdir(dirname('projects/'.$fileName.'/'.$CHiFolderName.'/'.$fileName.'.chi'), 0777, true); //param true makes it recursive
	}

	// Check if folder exists, just in case
	if (file_exists(dirname('projects/'.$fileName.'/'.$CHiFolderName.'/'.$fileName.'.chi')))
	{
        if (move_uploaded_file($_FILES['fileUploaded']['tmp_name'], 'projects/'.$fileName.'/'.$CHiFolderName.'/'.$fileName.'.chi')) {

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