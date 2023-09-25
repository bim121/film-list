<?php
    unlink(__DIR__ . "/../data/film/" . $_GET['file']);
    header('Location: ../index.php');
?>