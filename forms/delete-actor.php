<?php
    include(__DIR__ . '/../auth/check-auth.php');
    if(!CheckRight('actor', 'delete')){
        die("Ви не маєте права на виконання цієї операції");
    }

    unlink(__DIR__ . "/../data/". $_GET['film'] . "/" . $_GET['file']);
    header('Location: ../index.php?film=' . $_GET['film']);
?>