<?php
  // Of type javascript
  header('Content-type: text/javascript');
  $root = substr($_SERVER["PHP_SELF"], 0, strrpos($_SERVER["PHP_SELF"], '/'));
  echo "let _root='{$root}';\n";
?>
