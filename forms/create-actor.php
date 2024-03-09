<?php
    include(__DIR__ . '/../auth/check-auth.php');

    if($_POST){
       require_once '../model/autorun.php';
       $myModel = Model\Data::makeModel(Model\Data::FILE);
       $myModel->setCurrentUser($_SESSION['user']);

       $actor = (new \Model\Actor())
            ->setFilmId($_GET['film'])
            ->setName($_POST['actor_name'])
            ->setRoles($_POST['actor_roles'])
            ->setEpisode($_POST['actor_episodes'])
            ->setWorldClass($_POST['actor_worldClass']);
        if(!$myModel->addActor($actor)){
            die($myModel->getError());
        }else{
            header('Location: ../index.php?film=' . $_GET['film']);
        }
    }

    require_once '../view/autorun.php';
    $myView = \View\FilmListView::makeView(\View\FilmListView::SIMPLEVIEW);

    $myView->showActorCreateForm();
?>
