<?php 
    include(__DIR__ . "/../auth/check-auth.php");
   
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);
    if(!$user = $myModel->readUser($_GET['username'])){
        die($myModel->getError());
    }

    if($_POST){
        $rights = "";

        for($i = 0; $i < 9; $i++){
            if($_POST['right' . $i]){
                $rights .= "1";
            }else{
                $rights .= "0";
            }
        }
        $user = (new \Model\User())
            ->setUserName($_POST['user_name'])
            ->setPassword($_POST['user_pwd'])
            ->setRights($rights);
        if(!$myModel->writeUser($user)){
            die($myModel->getError());
        } else{
            header('Location: index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Редагування користувача</title>
</head>
<body>
    <a href="index.php">До списку користувачів</a>
    <form name="edit-user" method="post">
        <div class="tbl">
            <div>
                <label for="user_name">Username: </label>
                <input readonly type="text" name="user_name" value= '<?php echo $user->getUserName(); ?>'>
            </div>
            <div>
                <label for="user_pwd">Password: </label>
                <input readonly type="text" name="user_pwd" value= '<?php echo $user->getPassword(); ?>'>
            </div>
        </div>
        <div>
            <p>
                Фільм:
            </p>
            <input type="checkbox" <?php echo ("1" == $user->getRight(0)) ? "checked":""; ?> name="right0"
                value="1"><span>перегляд</span>
            <input type="checkbox" <?php echo ("1" == $user->getRight(1)) ? "checked":""; ?> name="right1"
                value="1"><span>створення</span>
            <input type="checkbox" <?php echo ("1" == $user->getRight(2)) ? "checked":""; ?> name="right2"
                value="1"><span>редагування</span>
            <input type="checkbox" <?php echo ("1" == $user->getRight(3)) ? "checked":""; ?> name="right3"
                value="1"><span>видалення</span>
        </div>
        <div>
            <p>
                Актори:
            </p>
            <input type="checkbox" <?php echo ("1" == $user->getRight(4)) ? "checked":""; ?> name="right4"
                value="1"><span>перегляд</span>
            <input type="checkbox" <?php echo ("1" == $user->getRight(5)) ? "checked":""; ?> name="right5"
                value="1"><span>створення</span>
            <input type="checkbox" <?php echo ("1" == $user->getRight(6)) ? "checked":""; ?> name="right6"
                value="1"><span>редагування</span>
            <input type="checkbox" <?php echo ("1" == $user->getRight(7)) ? "checked":""; ?> name="right7"
                value="1"><span>видалення</span>
        </div>
        <div>
            <p>
                Користувачі:
            </p>
            <input type="checkbox" <?php echo ("1" == $user->getRight(8)) ? "checked":""; ?> name="right8"
                value="1"><span>адміністрування</span>
        </div>
        <div>
            <input type="submit" name="ok" value="змінити">
        </div>
    </form>
</body>
</html>