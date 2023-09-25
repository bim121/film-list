<?php 
    require('./data/declare-data.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main-style.css">
    <link rel="stylesheet" href="./css/roles-style.css">
    <title>Фільм</title>
</head>
<body>
    <header>
        <h1>Назва фільму <span class="film-name"><?php echo $data['film']['name']; ?></span></h1>
        <h3>Рік виходу: <span class="film-year"><?php echo $data['film']['year']; ?></span></h3>
        <h3>Країна: <span class="film-country"><?php echo $data['film']['country']; ?></span></h3>
        <a href="./forms/edit-film.php">Редагувати фільм</a>
    </header>
    <section>
        <a href="./forms/create-actor.php">Додати актера</a>
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
                                <a href="./forms/edit-actor.php?file=<?php
                                echo $actor['file']; ?>">
                                Редагувати</a>
                                <a href="./forms/delete-actor.php?file=<?php
                                echo $actor['file']; ?>">
                                Видалити</a>
                            </td>
                        </tr>
                    <?php endif; ?> 
                <?php endforeach; ?>
            </tbody>    
        </table>
    </section>
</body>
</html>