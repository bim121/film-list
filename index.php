<?php 
    require('auth/check-auth.php');
    require_once 'model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main-style.css">
    <link rel="stylesheet" href="./css/roles-style.css">
    <link rel="stylesheet" href="./css/film-choose-style.css">
    <title>Фільм</title>
</head>
<body>
    <header>
        <div class="user-info">
            <span>Hello <?php echo $_SESSION['user']; ?> !</span>
            <?php if ($myModel->CheckRight('user', 'admin')): ?>
                <a href="admin/index.php">Адміністрування</a>    
            <?php endif; ?>
            <a href="auth/logout.php">Logout</a>
        </div>
        <?php if($myModel->CheckRight('film', 'view')):?>
            <?php $data['films'] = $myModel->readFilms(); ?>
            <form name="film-form" method="get">
                <label for="film">Фільм</label>
                <select name = "film">
                    <option value=""></option>
                    <?php 
                        foreach ($data['films'] as $curfilm){
                            echo "<option " . (($curfilm->getId() == $_GET['film'])?"selected":"") . " value='" . $curfilm->getId() . "''>" . $curfilm->getName() . "</option>";
                        }
                    ?>
                </select>
                <input type="submit" value="ok">
                <?php if($myModel->CheckRight('film', 'create')):?>
                    <a href="forms/create-film.php">Додати фільм</a>
                <?php endif; ?>
            </form>
            <?php if($_GET['film']): ?>
                <?php
                    $data['film'] = $myModel->readFilm($_GET['film']);
                ?>
                <h1>Назва фільму <span class="film-name"><?php echo $data['film']->getName(); ?></span></h1>
                <h3>Рік виходу: <span class="film-year"><?php echo $data['film']->getYear(); ?></span></h3>
                <h3>Країна: <span class="film-country"><?php echo $data['film']->getCountry(); ?></span></h3>
                <div class="control">
                    <?php if($myModel->CheckRight('film', 'edit')):?>
                        <a href="./forms/edit-film.php?film=<?php echo $_GET['film']; ?>">Редагувати фільм</a>
                    <?php endif; ?>
                    <?php if($myModel->CheckRight('film', 'delete')):?>
                        <a href="./forms/delete-film.php?film=<?php echo $_GET['film']; ?>">Видалити фільм</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </header>
    <?php if($myModel->CheckRight("actor", 'view')):?>
        <?php $data['actors'] = $myModel->readActors($_GET['film']);?>
        <section>
            <?php if($_GET['film']): ?>
                <?php if($myModel->CheckRight("actor", 'create')):?>
                    <div class="control">
                        <a href="./forms/create-actor.php?film=<?php echo $_GET['film'] ?>">Додати актера</a>
                    </div>
                <?php endif; ?>
                <form name="actors-filter" method="post">
                    Фільтрація за іменем <input type="text" name="actor_name_filter" value='<?php echo $_POST['actor_name_filter']; ?>'>
                    <input type="submit" value="Фільтрувати">
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>№ актера</th>
                            <th>Ім'я</th>
                            <th>Роль в фільмі</th>
                            <th>Епізод</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['actors'] as $key => $actor): ?>
                            <?php if(!$_POST['actor_name_filter'] || stristr($actor->getName(), $_POST['actor_name_filter'])): ?>
                                <?php
                                    $row_class = 'row';
                                    if($actor->getRoles() == 'main'){
                                        $row_class = 'main-role';
                                    }else{
                                        $row_class = 'support-role';
                                    }
                                ?>
                                <tr class="<?php echo $row_class; ?>">
                                    <td><?php echo ($key+1); ?></td>
                                    <td><?php echo $actor->getName(); ?></td>
                                    <td><?php echo $actor->getRoles(); ?></td>
                                    <td><?php echo $actor->getEpisode(); ?></td>
                                    <td>
                                        <?php if($myModel->CheckRight("actor", 'edit')):?>
                                            <a href="./forms/edit-actor.php?film=<?php
                                            echo $_GET['film']; ?>&file=<?php echo $actor->getId();?>">
                                            Редагувати</a>
                                        <?php endif; ?>
                                            <?php if($myModel->CheckRight("actor", 'delete')):?>
                                            <a href="./forms/delete-actor.php?film=<?php
                                            echo $_GET['film']; ?>&file=<?php echo $actor->getId(); ?>">
                                            Видалити</a>
                                        <?php endif?>
                                    </td>
                                </tr>
                            <?php endif; ?> 
                        <?php endforeach; ?>
                    </tbody>    
                </table>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</body>
</html>