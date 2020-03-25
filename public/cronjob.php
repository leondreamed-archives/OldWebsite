<?php
  define('ROOT', substr($_SERVER["PHP_SELF"], 0, strrpos($_SERVER["PHP_SELF"], '/') + 1));
  $newArticle = false;
  $articles = array();
  $info = json_decode(file_get_contents(ROOT.'/articles/info.json'), true);
  $meta = json_decode(file_get_contents(ROOT.'/articles/meta.json'), true);
  
  print_r(glob(ROOT.'/articles/content/*', GLOB_ONLYDIR));
  
  foreach (glob(ROOT.'/articles/content/*', GLOB_ONLYDIR) as $articleDir) {
    // Getting the filename
    $articleFilename = array();
    preg_match('~[^/]+$~', $articleDir, $articleFilename);
    $articleFilename = isset($articleFilename[0]) ? $articleFilename[0] : "";

    if (!isset($meta[$articleFilename])) {
      $newArticle = true;

      // Parsing Display Name
      $articleName = preg_replace('~-~', ' ', ucwords($articleFilename, '-'));
      
      // Setting properties needed for article-box
      $curArticle = array();
      
      $curArticle['title'] = $articleName;
      $curArticle['root'] = "/articles/content/{$articleFilename}";
      $curArticle['id'] = uniqid("", true);
      
      if (isset($info[$articleFilename])) {
        $curArticle['desc'] = $info[$articleFilename]['desc'];
        $curArticle['publishdate'] = $info[$articleFilename]['publishdate'];
        $curArticle['lastupdated'] = $info[$articleFilename]['lastupdated'];
      }
      
      $meta[$articleFilename] = $curArticle;
      print_r($curArticle);
    }
  }
  
  if ($newArticle) {
    uasort($meta, function($a, $b) {
      $datestr1 = $a['lastupdated'] ? $a['lastupdated'] : $a['publishdate'];
      $datestr2 = $b['lastupdated'] ? $b['lastupdated'] : $b['publishdate'];
      return strtotime($datestr2) <=> strtotime($datestr1);
    });
    
    file_put_contents(ROOT.'/articles/meta.json', json_encode($meta));
  }

?>
