<?php

require_once '../src/init.php';

  
$request = str_replace($config['urls']['baseUrl'],'',$_SERVER['REQUEST_URI']);
$request = strtok($request, '?');   

$templates = new League\Plates\Engine('../src/view');

    if ($request === '/' || $request === '/tapahtumat') {
      echo $templates->render('tapahtumat');
    } else if ($request === '/tapahtuma') {
      echo $templates->render('tapahtuma');
    } else {
      echo $templates->render('notfound');
    }
  

?> 
