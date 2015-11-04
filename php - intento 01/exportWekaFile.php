<?php
// include "C:\Program Files\chromePHP\ChromePhp.php";

// error_reporting(E_ALL);



$projectName = $_POST['projectName'];
$dirInputFiles = 'projects/'.$projectName;
$dirOutputFiles = 'projects-Comments';

$userModificationsPath = 'projects/'.$projectName.'/CHi-files/user-modifications.csv';

$result = array();
$statusreturn = -2112;

$ret = array();
$ret['success'] = 0;
$ret['successMsg'] = "Success saving modifications";







file_put_contents($userModificationsPath, $_POST['exportString']);
exec('python ./python/2_process_web_output.py projects/'.$projectName.'/CHi-files/'.$projectName.'.chi '.$userModificationsPath,$result, $statusreturn);
if ($statusreturn!=0){
  $ret["success"] = 1;
  $ret["successMsg"] = "Failed to save modifications";
}
showExecOut($result,$statusreturn);
unset($result);
$result = array();



exec('python ./python/3_leave_only_text_and_class_in_the_csv.py projects/'.$projectName.'/CHi-files/'.$projectName.'-export.csv',$result, $statusreturn);
if ($statusreturn!=0){
  $ret["success"] = 2;
  $ret["successMsg"] = "Failed while pre-processing files to make the Weka export file";
}
showExecOut($result,$statusreturn);
unset($result);
$result = array();


exec('python ./python/4_csv2arff.py "projects/'.$projectName.'/CHi-files/'.$projectName.'-export_(only comments and class).csv" string "{non-directive,directive}"',$result, $statusreturn);
if ($statusreturn!=0){
  $ret["success"] = 3;
  $ret["successMsg"] = "Failed to create the .arff file while doing the Weka export file";
}
showExecOut($result,$statusreturn);
unset($result);
$result = array();








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