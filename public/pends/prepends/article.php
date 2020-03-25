<script async>
<?php
$root = substr($_SERVER["PHP_SELF"], 0, strrpos($_SERVER["PHP_SELF"], '/') + 1);
echo "let _root='{$root}';";
preg_match('~([^/]+)/[^/]+/[^/]+$~', $_SERVER["PHP_SELF"], $matches);
$filename = isset($matches[1]) ? $matches[1] : "";
$info = json_decode(file_get_contents(ROOT.'/articles/meta.json'), true);
$id = $info[$filename]['id'];
$title = $info[$filename]['title'];
echo <<<JS
let articleinfo = {
  name: "$filename",
  id: "$id",
  title: "$title"
};

JS;
?>

$(function() {
  $('head').append('<link href="/articles/index.css" rel="stylesheet" type="text/css" />');

  let h1 = $('<h1>');
  h1.html(articleinfo.title);
  h1.attr('class', 'article-title');
  $('.article').prepend(h1);
});
</script>
<div class="text-content article">
