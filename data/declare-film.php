<?php 
    $file = fopen(__DIR__ . "/" . $filmFolder . "/film.txt", 'r');
    $fStr = fgets($file);
    $fArr = explode(";", $fStr);
    fclose($file);

    $data['film'] = array(
        'name' => $fArr[0],
        'year' => $fArr[1],
        'country' => $fArr[2]
    );
?>