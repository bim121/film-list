<?php
    if($_POST){
        $nameTpl = '/^actor-\d\d.txt\z/';
        $path = __DIR__ . "/../data/" . $_GET['film'];
        $conts = scandir($path);
        $i = 0;
        foreach($conts as $node){
            if(preg_match($nameTpl, $node)){
                $last_file = $node;
            }
        }

        $file_index = (String)(((int)substr($last_file, -6, 2)) + 1);
        if(strlen($file_index) == 1){
            $file_index = "0" . $file_index;
        }

        $newFileName = "actor-" . $file_index . ".txt";

        $file= fopen("../data/" . $_GET['film'] . "/" . $newFileName, "w");
        $worldClass = 0;
        if($_POST['actor_worldClass' == 1]){
            $worldClass = 1;
        }
        $fArr = array($_POST['actor_name'], $_POST['actor_roles'], $_POST['actor_episodes'], $worldClass, );
        $fStr = implode(";", $fArr);
        fwrite($file, $fStr);
        fclose($file);
        header('Location: ../index.php?film' . $_GET['film']);
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