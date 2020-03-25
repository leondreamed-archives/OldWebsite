<?php
$cssFile = $dirname.'/index.css';

if (file_exists(ROOT.$cssFile)) {
echo <<<JS
  $('head').append(`<link rel="preload" type="text/css" href="{$cssFile}" as="style"/>`);
  $('head').append(`<link rel="stylesheet" type="text/css" href="{$cssFile}"/>`);
  
JS;
}
?>
