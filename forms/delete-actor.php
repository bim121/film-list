<?php
    unlink(__DIR__ . "/../data/". $_GET['film'] . "/" . $_GET['file']);
    header('Location: ../index.php?film=' . $_GET['film']);
?>