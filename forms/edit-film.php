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
            value="<?php echo $data['film']->getName(); ?>"></div>
        <div><label for="year">Рік виходу: </label><input type="text" name="year"
            value="<?php echo $data['film']->getYear(); ?>"></div>
        <div><label for="country">Країна: </label><input type="text" name="country"
            value="<?php echo $data['film']->getCountry(); ?>"></div>
        <div><input type="submit" name="ok" value="змінити"></div>
    </form>    
</body>
</html>