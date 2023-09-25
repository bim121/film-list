<?php 
    $nameTpl = '/^actor-\d\d.txt\z/';
    $path = __DIR__ . "/film";
    $conts = scandir($path);

    $i = 0;

    foreach($conts as $node){
        if(preg_match($nameTpl, $node)){
            $data['actors'][$i] = require __DIR__ . '/declare-actor.php';
            $i++;
        }
    }
?>