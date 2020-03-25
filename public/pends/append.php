<?php
$next = array_pop($types);
if ($next == 'script') {
  require ROOT.'/pends/appends/script.php';
} else if ($next == 'page') {
  require ROOT.'/pends/appends/page.php';
} else if ($next == 'article') {
  require ROOT.'/pends/appends/article.php';
  require ROOT.'/pends/appends/page.php';
}

?>
