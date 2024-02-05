<?php
    include(__DIR__ . '/../auth/check-auth.php');
    if(!CheckRight('film', 'create')){
        die("Ви не маєте права на виконання цієї операції");
    }

    $nameTpl = '/^film-\d\d\z/';
    $path = __DIR__ . "/../data";
    $conts = scandir($path);
    $i = 0;

    foreach($conts as $node){
        if(preg_match($nameTpl, $node)){
            $last_film = $node;
        }
    }

    $film_index = (String)(((int)substr($last_film, -1, 2)) + 1);
    if(strlen($film_index) == 1){
        $film_index = "0" . $film_index;
    }

    $newFilmName = 'film-' . $film_index;

    mkdir(__DIR__ . "/../data/" . $newFilmName);
    $file = fopen(__DIR__ . "/../data/" . $newFilmName . '/film.txt', "w");
    fwrite($file, "New; ; ");
    fclose($file);
    header("Location: ../index.php?film=" . $newFilmName);
?>