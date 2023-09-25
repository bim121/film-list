<?php
    $f = fopen($path . "/" . $node, "r");
    $rowStr = fgets($f);
    $rowArr = explode(";", $rowStr);
    $actor["file"] = $node;
    $actor["name"] = $rowArr[0];
    $actor["roles"] = $rowArr[1];
    $actor["episode"] = $rowArr[2];
    $actor["worldClass"] = $rowArr[3];
    fclose($f);

    return $actor;
?>