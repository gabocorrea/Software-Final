<?php
include "C:\Program Files\chromePHP\ChromePhp.php";

error_reporting(E_ALL);
/* falta mostrar de alguna forma, los errores de este script */



$CHiFolderName = 'CHi-files';

$projectName = $_POST['projectName'];
$dirInputFiles = 'projects/'.$projectName;
$dirOutputFiles = 'projects-Comments';

$result = array();
$statusreturn = -2112;

$ret = array();
$ret['success'] = 0;
$ret['successMsg'] = "Success creating project";

exec('rmdir "'.$dirOutputFiles.'"',$result, $statusreturn);//TODO: aca probablemente hay un bug... no se debería borrar cada vez
// showExecOut($result,$statusreturn);
unset($result);
$result = array();

exec('mkdir "'.$dirOutputFiles.'"',$result, $statusreturn);
// showExecOut($result,$statusreturn);
unset($result);
$result = array();


exec('slocc.sh -findopt "-name *.java" -raw -dest_dir "'.$dirOutputFiles.'" -comment "'.$dirInputFiles.'"',$result, $statusreturn);
// showExecOut($result,$statusreturn);
unset($result);
$result = array();



//If folders haven't been created, create them 
if (!file_exists(dirname('./'.$dirInputFiles.'/'.$CHiFolderName.'/project.csv')))
{               
  mkdir(dirname('./'.$dirInputFiles.'/'.$CHiFolderName.'/project.csv'), 0777, true); //param true makes it recursive
}
exec('python ./python/1_convert-comments-in-many-files-to-one-csv___separated_by_phrases.py -m 4 -c NONE ./'.$dirOutputFiles.'/projects/'.$projectName.' ./'.$dirInputFiles.'/'.$CHiFolderName.'/project.csv',$result, $statusreturn);
// showExecOut($result,$statusreturn);
unset($result);
$result = array();


// The following commented code should be on a new <aName>.php file, triggered when user wants to export to an .arff file

// ChromePhp::log( 'deleting unnecesary data from .csv file');
// exec('python ./python/3_leave_only_text_and_class_in_the_csv.py Comments_WebOutput.csv',$result, $statusreturn);
// showExecOut($result,$statusreturn);
// unset($result);
// $result = array();
// ChromePhp::info('python ./python/3_leave_only_text_and_class_in_the_csv.py Comments_WebOutput.csv');


// ChromePhp::log( 'transforming .csv file to an .arff file');
// exec('python ./python/4_csv2arff.py "Comments_WebOutput_(only comments and class).csv" string "{non-directive,directive}"',$result, $statusreturn);
// showExecOut($result,$statusreturn);
// unset($result);
// $result = array();
// ChromePhp::info('python ./python/4_csv2arff.py "Comments_WebOutput_(only comments and class).csv" string "{non-directive,directive}"');


echo json_encode($ret);


function showExecOut($result,$statusreturn)
{
  if ($statusreturn == 0)
  {
    ChromePhp::log( ' --- statusreturn is 0');
  } elseif ($statusreturn == 1) {
    ChromePhp::log( ' --- statusreturn is 1');
  } else {
    ChromePhp::log( ' --- statusreturn is not 0 and is not 1');
  }
 
  if (is_array($result) || is_object($result))
  {
    foreach ($result as $line)
    {
      ChromePhp::log( ' --- --- --- '.$line);
    }
  } else {
    ChromePhp::log( ' (not an array) --- --- ---');
  }
  
  ChromePhp::log( '');
}



?>