<?php
  //הגדרות וחיבורים ופונקציות בסיסיות
  require __DIR__ . '/src/config/settings.php';
  require __DIR__ . '/src/config/database.php';
  require __DIR__ . '/src/config/functions.php';

  //בדיקה במקרה של הפעלה דרך פקודת PHP מהטררמינל
  if(isset($argv[1])){
    $request_patch = $argv[1];
  }else{
    $request_patch = $_SERVER['REQUEST_URI'];
  }
  $patchs = explode('/',$request_patch);
  if(is_array($settings[$patchs[1]][$patchs[2]])){
    $app_settings = $settings[$patchs[1]][$patchs[2]];
    //ניתוב על בסיס ההגדרות
    require __DIR__ .'/'. $app_settings['source'] . '/' . $app_settings['main'];
  }
