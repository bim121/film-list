<?php 
    $nameTpl = '/^film-\d\d\z/';
    $path = __DIR__;
    $conts = scandir($path);
    $i = 0;
    foreach($conts as $node){
        if(preg_match($nameTpl, $node)){
            $filmFolder = $node;
            require(__DIR__ . '/declare-film.php');

            $data['films'][$i]['name'] = $data['film']['name'];
            $data['films'][$i]['file'] = $filmFolder;
            $i++;
        }
    }
?>