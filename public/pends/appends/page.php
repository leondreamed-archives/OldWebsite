<footer>
  <div id="_site-footer"></div>
  <script type="module" id="site-footer-script" src="/sections/site-footer/load.php" async crossorigin="anonymous"></script>
</footer>
<script>
$('head').append(`<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i%7CPT+Sans:400,700&display=swap" rel="stylesheet" crossorigin="anonymous"/>
<link href="/pends/main.css" rel="preload" as="style" type="text/css" defer="defer" />
<link href="/pends/main.css" rel="stylesheet" type="text/css"/>
<?php
$myStyle = $dirname.'index.css';
if (file_exists(ROOT.$myStyle)) {
  echo <<<XML
<link href="{$myStyle}" rel="preload" as="style" type="text/css" />
<link href="{$myStyle}" rel="stylesheet" type="text/css" />
XML;
}
?>`);

</script>
</body>
</html>
