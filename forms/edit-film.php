<?php
    include(__DIR__ . '/../auth/check-auth.php');
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    if($_POST){
      if(!$myModel->writeFilm((new \Model\Film())
        ->setId($_GET['film'])
        ->setName($_POST['name'])
        ->setYear($_POST['year'])
        ->setCountry($_POST['country'])
      )) {
        die($myModel->getError());
      } else {
        header('Location: ../index.php?film=' . $_GET['film']);
      }
    }
    if(!$data['film'] = $myModel->readFilm($_GET['film'])){
        die($myModel->getError());
    }

    $film = new \Model\Film();
    if($_GET['film'] && $myModel->checkRight('film', 'edit')){
        $film = $myModel->readFilm($_GET['film']);
    }

    require_once '../view/autorun.php';
    $myView = \View\FilmListView::makeView(\View\FilmListView::SIMPLEVIEW);
    $myView->setCurrentUser($myModel->getCurrentUser());

    $myView->showFilmEditForm($film);
?>