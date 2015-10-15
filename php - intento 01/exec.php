<?php
include "C:\Program Files\chromePHP\ChromePhp.php";

error_reporting(E_ALL);
/* falta mostrar de alguna forma, los errores de este script */

ChromePhp::log("projectName:".$_POST['projectName']);



$projectName = $_POST['projectName'];
$dirInputFiles = 'projects/'.$projectName;
$dirOutputFiles = 'projects-Comments';

$result = array();
$statusreturn = -2112;

ChromePhp::log( 'removing projects-Comments folder');
exec('rmdir "'.$dirOutputFiles.'"',$result, $statusreturn);
showExecOut($result,$statusreturn);
unset($result);
$result = array();

ChromePhp::log( 'creating projects-Comments folder');
exec('mkdir "'.$dirOutputFiles.'"',$result, $statusreturn);
showExecOut($result,$statusreturn);
unset($result);
$result = array();


ChromePhp::log( 'extracting comments from all files');
exec('slocc.sh -findopt "-name *.java" -raw -dest_dir "'.$dirOutputFiles.'" -comment "'.$dirInputFiles.'"',$result, $statusreturn);
showExecOut($result,$statusreturn);
unset($result);
$result = array();
ChromePhp::log('slocc.sh -findopt "-name *.java" -raw -dest_dir "'.$dirOutputFiles.'" -comment "'.$dirInputFiles.'"');

ChromePhp::log( 'separating phrases and building comma separated file (Comments.csv)');
exec('python ./python/1_convert-comments-in-many-files-to-one-csv___separated_by_phrases.py -m 4 -c NONE ./'.$dirOutputFiles.'/projects/'.$projectName.' Comments.csv',$result, $statusreturn);
showExecOut($result,$statusreturn);
unset($result);
$result = array();
ChromePhp::info('python ./python/1_convert-comments-in-many-files-to-one-csv___separated_by_phrases.py -m 4 -c NONE ./'.$dirOutputFiles.'/'.$projectName.' Comments.csv');

ChromePhp::log( 'exporting web modifications');
file_put_contents('out_web.csv', $_POST['exportString']);
exec('python ./python/2_process_web_output.py',$result, $statusreturn);
showExecOut($result,$statusreturn);
unset($result);
$result = array();
ChromePhp::info('python ./python/2_process_web_output.py');

ChromePhp::log( 'deleting unnecesary data from .csv file');
exec('python ./python/3_leave_only_text_and_class_in_the_csv.py Comments_WebOutput.csv',$result, $statusreturn);
showExecOut($result,$statusreturn);
unset($result);
$result = array();
ChromePhp::info('python ./python/3_leave_only_text_and_class_in_the_csv.py Comments_WebOutput.csv');


ChromePhp::log( 'transforming .csv file to an .arff file');
exec('python ./python/4_csv2arff.py "Comments_WebOutput_(only comments and class).csv" string "{non-directive,directive}"',$result, $statusreturn);
showExecOut($result,$statusreturn);
unset($result);
$result = array();
ChromePhp::info('python ./python/4_csv2arff.py "Comments_WebOutput_(only comments and class).csv" string "{non-directive,directive}"');



ChromePhp::log( 'done');


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