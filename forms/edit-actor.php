<?php
    include(__DIR__ . '/../auth/check-auth.php');
   
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    if($_POST){
        $actor = (new \Model\Actor())
            ->setId($_GET['file'])
            ->setFilmId($_GET['film'])
            ->setName($_POST['actor_name'])
            ->setRoles($_POST['actor_roles'])
            ->setEpisode($_POST['actor_episodes'])
            ->setWorldClass($_POST['actor_worldClass']);
        if(!$myModel->writeActor($actor)){
            die($myModel->getError());
        }else{
            header('Location: ../index.php?film=' . $_GET['film']);
        }
    }

    $actor = $myModel->readActor($_GET['film'], $_GET['file']);

    require_once '../view/autorun.php';

    $myView = \View\FilmListView::makeView(\View\FilmListView::SIMPLEVIEW);
    $myView->setCurrentUser($myModel->getCurrentUser());

    $myView->showActorEditForm($actor);
?>