<?php
include "C:\Program Files\chromePHP\ChromePhp.php";

error_reporting(E_ALL);
/* falta mostrar de alguna forma, los errores de este script */

// ChromePhp::log("projectName:".$_POST['projectName']);


$projectName = $_POST['projectName'];
$dirInputFiles = 'projects/'.$projectName;
$dirOutputFiles = 'projects-Comments';

$userModificationsPath = 'projects/'.$projectName.'/CHi-files/user-modifications.csv';

$result = array();
$statusreturn = -2112;

$ret = array();
$ret['success'] = 1;
$ret['successMsg'] = "Success exporting file";

// ChromePhp::log( 'exporting web modifications');
file_put_contents($userModificationsPath, $_POST['exportString']); //TODO: cambiar nombre y directorio de out_web.csv
exec('python ./python/2_process_web_output.py projects/'.$projectName.'/CHi-files/project.csv '.$userModificationsPath,$result, $statusreturn);
showExecOut($result,$statusreturn);
unset($result);
$result = array();
// ChromePhp::info('python ./python/2_process_web_output.py projects/'.$projectName.'/CHi-files/project.csv '.$userModificationsPath);

// ChromePhp::log( 'done');


echo json_encode($ret);


function showExecOut($result,$statusreturn)
{
  if ($statusreturn == 0)
  {
    // ChromePhp::log( ' --- statusreturn is 0');
  } elseif ($statusreturn == 1) {
    // ChromePhp::log( ' --- statusreturn is 1');
  } else {
    // ChromePhp::log( ' --- statusreturn is not 0 and is not 1');
  }
 
  if (is_array($result) || is_object($result))
  {
    foreach ($result as $line)
    {
      // ChromePhp::log( ' --- --- --- '.$line);
    }
  } else {
    // ChromePhp::log( ' (not an array) --- --- ---');
  }
  
  // ChromePhp::log( '');
}



?>