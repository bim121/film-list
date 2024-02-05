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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додавання актора</title>
    <link rel="stylesheet" href="../css/edit-actor-style.css">
</head>
<body>
<a href="../index.php">На головну</a>
    <form name="edit-student" method="post">
        <div>
            <label for="actor_name"></label>
            <input type="text" name="actor_name" >
        </div>
        <div>
            <label for="actor_roles"></label>
            <select name="actor_roles">
                <option disabled>Roles</option>
                <option value="main">main roles</option>
                <option value="supporting actor">support roles</option>
            </select>
        </div>
        <div>
            <label for="actor_episodes">Episode: </label>
            <input type="number" name="actor_episodes">
        </div>
        <div>
            <input type="checkbox" name="actor_worldClass"> world class
        </div>
        <div><input type="submit" name="ok" value="Додати"></div>
    </form>
</body>
</html>