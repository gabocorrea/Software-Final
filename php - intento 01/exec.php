<?php
  echo 'removing ./out/ folder';
  exec('rmdir out');
  echo 'creating ./out/ folder';
  exec('mkdir out');
  echo 'extracting comments from all files'
  exec('slocc.sh -findopt "-name *.java" -raw -dest_dir "out" -comment collections');//,$result, $statusreturn);
  echo ''

  echo 'done';
?>