<?php
// include "C:\Program Files\chromePHP\ChromePhp.php";
// 
//error_reporting(E_ALL);

header('Content-type: application/json'); //don't know what this line does, so i commented it



$ret = $_POST;
$ret["success"] = 0;
$ret["successMsg"] = "Success uploading folder";

$count = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	if (is_array($_FILES['folderPost']['name']) || is_object($_FILES['folderPost']['name']) || true)
	{
	    $valFullPath = $_POST['folderPostFullDirectory'];

	    foreach ($_FILES['folderPost']['name'] as $key => $val) {
	        if (strlen($_FILES['folderPost']['name'][$key]) > 1) {


	        	$fixedFullPath = fixFolderName($valFullPath[$key]);


				//If folders haven't been created, create them recursively
				if (!file_exists(dirname('projects/'.$fixedFullPath)))
				{
					mkdir(dirname('projects/'.$fixedFullPath), 0777, true); //param true makes it recursive
				}

				//If file already exists modify name, to allow a 2nd copy
				if (file_exists('projects/'.$fixedFullPath)) {
		            if (move_uploaded_file($_FILES['folderPost']['tmp_name'][$key], 'projects/(warning_repeated_file_'.$fixedFullPath)) {
		        		$count++;
		            }
				} else {
					// Check if folder exists, just in case
					if (file_exists(dirname('projects/'.$fixedFullPath)))
						{
			            if (move_uploaded_file($_FILES['folderPost']['tmp_name'][$key], 'projects/'.$fixedFullPath)) {
			        		$count++;
			            }
		        	} else {
						$ret["success"] = 3;
						$ret["successMsg"] = "Failed to create folders for project in server";
		        	}
		        }
	        }
	    }

	   
	    $ret["uploadedFilesCount"] = $count;

	} else { // Else, there was an programming error related to de $_FILES variable
		$ret["success"] = 1;
		$ret["successMsg"] = "Internal upload problem";
	}

    // Check if any problems uploading all files
	if (is_array($_FILES['folderPost']['error'])) {
		foreach ($_FILES['folderPost']['error'] as $key => $val) {
			if($val != 0)
			{
				$ret["success"] = 2;
				$ret["successMsg"] = "Problem uploading file ".$_FILES['folderPost']['name'][$key];
			}
		}
	}

	//return project name (the name of the folder of the project, after being fixed if it had whitespace characters)
	$ret["projectName"] = getProjectName($valFullPath[0]); //0 because is the first file. any file can give us the root path.

	echo json_encode($ret);
}












// Recursively fixes names of all folders of the given path, that should be the path of a file.
// (e.g. folder "one/folder two/file name.csv" returns "folder_one/folder_two/file_name.csv")
function fixFolderName($path)
{
	$parts = explode('/',$path);
	if (count($parts) > 1)
	{
		$osPathSeparator = '/';

	} else {
		unset($parts);
		$parts = explode('\\',$path); // my paths are built with '/'
		if (count($parts) > 1)
		{
			$osPathSeparator = '\\';
		}
	}

	$fixedParts = array();
	foreach ($parts as $p)
	{
		array_push($fixedParts, implode('_',explode(' ',$p)));
	}
	unset($p);
	if (implode($osPathSeparator,$fixedParts) == ""  ||  implode($osPathSeparator,$fixedParts) === undefined) {
	
	}
	return implode($osPathSeparator,$fixedParts);
}

// Recursively fixes names of all folders of the given path, that should be the path of a file.
// Then returns the root folder, which is taken to be the projectName.
// (e.g. folder "one/folder two/file name.csv" returns "folder_one")
// (Implementation is similar to upload.php#fixFolderName)
function getProjectName($path)
{
	$parts = explode('/',$path);
	if (count($parts) > 1)
	{
		$osPathSeparator = '/';

	} else {
		unset($parts);
		$parts = explode('\\',$path); // my paths are built with '/'
		if (count($parts) > 1)
		{
			$osPathSeparator = '\\';
		}
	}

	$fixedParts = array();
	foreach ($parts as $p)
	{
		array_push($fixedParts, implode('_',explode(' ',$p)));
	}
	unset($p);
	return $fixedParts[0];
}



?>