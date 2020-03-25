<?php

echo <<<XML
<!DOCTYPE html>
<html lang="en-CA">
<head>

<title>ZaLion</title>
<meta charset="UTF-8"/>
<script src="https://unpkg.com/react@16/umd/react.production.min.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" crossorigin></script>
<script src="/pends/main.js" defer="defer"></script>

XML;

$myScript = $dirname.'/index.js';
if (file_exists(ROOT.$myScript)) {
echo <<<XML
<script src="{$myScript}" type="module" async crossorigin="anonymous"></script>
XML;
}

echo <<<XML
</head>
<body>

<div id="_tab-container"></div>
<div id="_announcements-banner"></div>

<script type="module" src="/sections/tab-container/load.php" async crossorigin="anonymous"></script>
<script type="module" src="/sections/announcements-banner/load.php" async crossorigin="anonymous"></script>

XML;
?>
