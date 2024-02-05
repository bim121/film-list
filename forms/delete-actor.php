<?php
    include(__DIR__ . '/../auth/check-auth.php');

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    $actor = (new \Model\Actor())->setId($_GET['file'])->setFilmId($_GET['film']);
    if(!$myModel->removeActor($actor)){
        die($myModel->getError());
    }else{
        header('Location: ../index.php?film=' . $_GET['film']);
    }
?>