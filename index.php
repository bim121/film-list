<?php 
    require 'controller/autorun.php';
    $controller = new \Controller\FilmListApp(\Model\Data::FILE, \View\FilmListView::SIMPLEVIEW);
    $controller->run();
?>
