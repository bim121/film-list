<?php 
    require('auth/check-auth.php');
    require('./data/declare-films.php')
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
            <a href="auth/logout.php">Logout</a>
        </div>
        <?php if(CheckRight('film', 'view')):?>
            <form name="film-form" method="get">
                <label for="film">Фільм</label>
                <select name = "film">
                    <option value=""></option>
                    <?php 
                        foreach ($data['films'] as $curfilm){
                            echo "<option " . (($curfilm['file'] == $_GET['film'])?"selected":"") . " value='" . $curfilm['file'] . "''>" . $curfilm['name'] . "</option>";
                        }
                    ?>
                </select>
                <input type="submit" value="ok">
                <?php if(CheckRight('film', 'create')):?>
                    <a href="forms/create-film.php">Додати фільм</a>
                <?php endif; ?>
            </form>
            <?php if($_GET['film']): ?>
                <?php
                    $filmFolder = $_GET['film'];
                    require('data/declare-data.php');
                ?>
                <h1>Назва фільму <span class="film-name"><?php echo $data['film']['name']; ?></span></h1>
                <h3>Рік виходу: <span class="film-year"><?php echo $data['film']['year']; ?></span></h3>
                <h3>Країна: <span class="film-country"><?php echo $data['film']['country']; ?></span></h3>
                <div class="control">
                    <?php if(CheckRight('film', 'edit')):?>
                        <a href="./forms/edit-film.php?film=<?php echo $_GET['film']; ?>">Редагувати фільм</a>
                    <?php endif; ?>
                    <?php if(CheckRight('film', 'delete')):?>
                        <a href="./forms/delete-film.php?film=<?php echo $_GET['film']; ?>">Видалити фільм</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </header>
    <?php if(CheckRight("actor", 'view')):?>
        <section>
            <?php if($_GET['film']): ?>
                <?php if(CheckRight("actor", 'create')):?>
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
                            <?php if(!$_POST['actor_name_filter'] || stristr($actor['name'], $_POST['actor_name_filter'])): ?>
                                <?php
                                    $row_class = 'row';
                                    if($actor['roles'] == 'main'){
                                        $row_class = 'main-role';
                                    }else{
                                        $row_class = 'support-role';
                                    }
                                ?>
                                <tr class="<?php echo $row_class; ?>">
                                    <td><?php echo ($key+1); ?></td>
                                    <td><?php echo $actor['name']; ?></td>
                                    <td><?php echo $actor['roles']; ?></td>
                                    <td><?php echo $actor['episode']; ?></td>
                                    <td>
                                        <?php if(CheckRight("actor", 'edit')):?>
                                            <a href="./forms/edit-actor.php?film=<?php
                                            echo $_GET['film']; ?>&file=<?php echo $actor['file']; ?>">
                                            Редагувати</a>
                                        <?php endif; ?>
                                            <?php if(CheckRight("actor", 'delete')):?>
                                            <a href="./forms/delete-actor.php?film=<?php
                                            echo $_GET['film']; ?>&file=<?php echo $actor['file']; ?>">
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