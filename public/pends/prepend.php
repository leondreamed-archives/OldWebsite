<?php
  define('ROOT', $_SERVER["DOCUMENT_ROOT"]);
  $types = array();
  $matches = array();
  
  ['basename' => $basename, 'dirname' => $dirname, 'extension' => $ext, 'filename' => $filename ] = pathinfo($_SERVER["PHP_SELF"]);
  
  $basename = basename($basename, '.php');
  $parentDir = substr($dirname, strrpos($dirname, '/') + 1);
  $baseDir = substr($dirname, 1, strpos($dirname, '/', 1) - 1);
  
  // If file is home page
  if ($parentDir == '/') {
    $dirname = '/pages/index/';
  }
  
  // If file is a PHP Script
  if ($parentDir == 'scripts' || $baseDir == 'scripts') {
    array_push($types, 'php');
  }
  
  
  // If file is a JS Script for rendering the element
  else if ($basename == 'load' || $ext == 'js') {
    array_push($types, 'script');
    require ROOT.'/pends/prepends/script.php';
  }
  
  else if ($baseDir == 'articles') {
    array_push($types, 'article');
    require ROOT.'/pends/prepends/page.php';
    require ROOT.'/pends/prepends/article.php';
  }
  
  // The element is a page
  else {
    array_push($types, 'page');
    require ROOT.'/pends/prepends/page.php';
  }
?>
