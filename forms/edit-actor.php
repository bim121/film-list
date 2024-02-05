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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагування актора</title>
    <link rel="stylesheet" href="../css/edit-actor-style.css">
</head>
<body>
    <a href="../index.php">На головну</a>
    <form name="edit-student" method="post">
        <div>
            <label for="actor_name"></label>
            <input type="text" name="actor_name" value='<?php echo $actor->getName(); ?>' >
        </div>
        <div>
            <label for="actor_roles"></label>
            <select name="actor_roles">
                <option disabled>Roles</option>
                <option  <?php echo ("main" == $actor->getRoles()) ? "selected": ""; ?> value="main">main roles</option>
                <option <?php echo ("supporting actor" == $actor->getRoles()) ? "selected": ""; ?> value="supporting actor">support roles</option>
            </select>
        </div>
        <div>
            <label for="actor_episodes">Episode: </label>
            <input type="number" name="actor_episodes" value='<?php echo $actor->getEpisode();; ?>'>
        </div>
        <div>
            <input type="checkbox" <?php echo ("1" == $actor->getWorldClass())?"checked" : ""; ?> name="actor_worldClass"> world class
        </div>
        <div><input type="submit" name="ok" value="Змінити"></div>
    </form>
</body>
</html>