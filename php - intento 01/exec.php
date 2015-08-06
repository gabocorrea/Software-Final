<?php
  echo 'removing ./out/ folder';
  exec('rmdir out');

  echo 'creating ./out/ folder';
  exec('mkdir out');

  echo 'extracting comments from all files';
  exec('slocc.sh -findopt "-name *.java" -raw -dest_dir "out" -comment collections');//,$result, $statusreturn);

  echo 'separating phrases and building comma separated file (Comments.csv)';
  exec('python ./python/1_convert-comments-in-many-files-to-one-csv___separated_by_phrases.py -m 4 -c NONE ./out Comments.csv');

  echo 'exporting data';
  file_put_contents('out_web.csv', $_POST['exportString']);
  exec('python ./python/2_process_web_output.py');

  echo 'done';
?>