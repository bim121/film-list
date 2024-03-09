<?php 
    require('auth/check-auth.php');
    
    require_once 'model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    require_once 'view/autorun.php';
    $myView = \View\FilmListView::makeView(\View\FilmListView::SIMPLEVIEW);
    $myView->setCurrentUser($myModel->getCurrentUser());

    $films = array();
    if($myModel->checkRight('film', 'view')){
        $films = $myModel->readFilms();
    }
    $film = new \Model\Film();
    if($_GET['film'] && $myModel->checkRight('film', 'view')){
        $film = $myModel->readFilm($_GET['film']);
    }
    $actors = array();
    if($_GET['film'] && $myModel->checkRight('actor', 'view')){
        $actors = $myModel->readActors($_GET['film']);
    }

    $myView->showMainForm($films, $film, $actors);
?>
