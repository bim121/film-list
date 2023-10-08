<?php
    if($_POST){
        $file = fopen("../data/" . $_GET['film'] . "/film.txt", 'w');
        $fArr = array($_POST['name'], $_POST['year'], $_POST['country']);
        $fStr = implode(";", $fArr);
        fwrite($file, $fStr);
        fclose($file);
        header("Location: ../index.php?film=" . $_GET['film']);
    }
    $filmFolder = $_GET['film'];
    require('../data/declare-film.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit-film-style.css">
    <title>Редагування фільму</title>
</head>
<body>
    <a href="../index.php">На головну</a>
    <form name="edit-film" method="post">
        <div><label for="name">Назва Фільму: </label><input type="text" name="name"
            value="<?php echo $data['film']['name']; ?>"></div>
        <div><label for="year">Рік виходу: </label><input type="text" name="year"
            value="<?php echo $data['film']['year']; ?>"></div>
        <div><label for="country">Країна: </label><input type="text" name="country"
            value="<?php echo $data['film']['country']; ?>"></div>
        <div><input type="submit" name="ok" value="змінити"></div>
    </form>    
</body>
</html>