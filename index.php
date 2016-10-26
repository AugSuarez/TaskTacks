<?php

spl_autoload_register('OG_autoload');
function OG_autoload($classname) {
  
    $classname = str_replace ('\\', '/', $classname);
    $filename = "app/controllers/". $classname .".php";
    require_once( __DIR__ . '/' .  $filename);
  
}

require 'app/helpers/helper.php';



switch (@$_GET['page']) {
    case 'agregar':
        //$task = new Task();
        //$task->show();
        call_user_func('Task', 'show');
        break;

    default:
        //call_user_func('Home::show');
        $home = new Home();
        $home->show();
        break;
}
