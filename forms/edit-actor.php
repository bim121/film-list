<?php
    if($_POST){
        $file = fopen("../data/film/" . $_GET['file'], "w");
        $worldClass = 0;
        if($_POST['actor_worldClass'] == 1){
            $worldClass = 1;
        }
        $fArr = array($_POST['actor_name'], $_POST['actor_roles'], $_POST['actor_episodes'], $worldClass,);
        $fStr=implode(";", $fArr);
        fwrite($file, $fStr);
        fclose($file);
        header('Location: ../index.php');
    }

    $path = __DIR__ . "/../data/film";
    $node = $_GET['file'];
    $actor = require __DIR__ . '/../data/declare-actor.php';
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
            <input type="text" name="actor_name" value='<?php echo $actor['name'] ?>' >
        </div>
        <div>
            <label for="actor_roles"></label>
            <select name="actor_roles">
                <option disabled>Roles</option>
                <option  <?php echo ("main" == $actor['roles']) ? "selected": ""; ?> value="main">main roles</option>
                <option <?php echo ("supporting actor" == $actor['roles']) ? "selected": ""; ?> value="supporting actor">support roles</option>
            </select>
        </div>
        <div>
            <label for="actor_episodes">Episode: </label>
            <input type="number" name="actor_episodes" value='<?php echo $actor['episode']; ?>'>
        </div>
        <div>
            <input type="checkbox" <?php echo ("1" == $actor["worldClass"])?"checked" : ""; ?> name="actor_worldClass"> world class
        </div>
        <div><input type="submit" name="ok" value="Змінити"></div>
    </form>
</body>
</html>