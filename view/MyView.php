<?php
    
    namespace View;
    class MyView extends FilmListView{
        private function showFilms($films){
            ?>
            <form name="film-form" method="get">
                <label for="film">Фільм</label>
                <select name = "film">
                    <option value=""></option>
                    <?php 
                        foreach ($films as $curfilm){
                            echo "<option " . (($curfilm->getId() == $_GET['film'])?"selected":"") . " value='" . $curfilm->getId() . "''>" . $curfilm->getName() . "</option>";
                        }
                    ?>
                </select>
                <input type="submit" value="ok">
                <?php if($this->CheckRight('film', 'create')):?>
                    <a href="?action=create-film">Додати фільм</a>
                <?php endif; ?>
            </form>
            <?php
        }

        private function showFilm(\Model\Film $film){
            ?>
            <h1>Назва фільму <span class="film-name"><?php echo $film->getName(); ?></span></h1>
            <h3>Рік виходу: <span class="film-year"><?php echo $film->getYear(); ?></span></h3>
            <h3>Країна: <span class="film-country"><?php echo $film->getCountry(); ?></span></h3>
            <div class="control">
                <?php if($this->CheckRight('film', 'edit')):?>
                    <a href="?action=edit-film-form&film=<?php echo $_GET['film']; ?>">Редагувати фільм</a>
                <?php endif; ?>
                <?php if($this->CheckRight('film', 'delete')):?>
                    <a href="?action=delete-film&film=<?php echo $_GET['film']; ?>">Видалити фільм</a>
                <?php endif; ?>
            </div>
            <?php
        }

        private function showActors($actors){
            ?>
                <section>
                    <?php if($_GET['film']): ?>
                        <?php if($this->CheckRight("actor", 'create')):?>
                            <div class="control">
                                <a href="?action=create-actor-form&film=<?php echo $_GET['film'] ?>">Додати актера</a>
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
                                <?php if (count($actors) > 0) : ?>
                                    <?php foreach($actors as $key => $actor): ?>
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
                                                    <?php if($this->CheckRight("actor", 'edit')):?>
                                                        <a href="?action=edit-actor-form&film=<?php
                                                        echo $_GET['film']; ?>&file=<?php echo $actor->getId();?>">
                                                        Редагувати</a>
                                                    <?php endif; ?>
                                                        <?php if($this->CheckRight("actor", 'delete')):?>
                                                        <a href="?action=delete-actor&film=<?php
                                                        echo $_GET['film']; ?>&file=<?php echo $actor->getId(); ?>">
                                                        Видалити</a>
                                                    <?php endif?>
                                                </td>
                                            </tr>
                                        <?php endif; ?> 
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>    
                        </table>
                    <?php endif; ?>
                </section>
            <?php
        }

        public function showMainForm($films, \Model\Film $film, $actors){
            ?>
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Список фільмів</title>
                        <link rel="stylesheet" type="text/css" href="css/main-style.css">
                        <link rel="stylesheet" type="text/css" href="css/roles-style.css">
                        <link rel="stylesheet" type="text/css" href="css/film-choose-style.css">
                    </head>
                    <body>
                        <header>
                            <div class="user-info">
                                <span>Hello <?php echo $_SESSION['user']; ?> !</span>
                                <?php if ($this->checkRight('user', 'admin')): ?>
                                    <a href="?action=admin">Адміністрування</a>
                                <?php endif; ?>
                                <a href="?action=logout">Logout</a>
                            </div>
                            <?php 
                                if($this->checkRight('film', 'view')){
                                    $this->showFilms($films);
                                    if($_GET['film']){
                                        $this->showFilm($film);
                                    }
                                }
                            ?>
                        </header>
                        <?php
                            if($this->checkRight('actor', 'view')){
                                $this->showActors($actors);
                            }
                        ?>
                    </body>
                </html>
            <?php
        }

        public function showFilmEditForm(\Model\Film $film){
            ?>
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Редагування фільму</title>
                        <link rel="stylesheet" type="text/css" href="css/edit-film-style.css">
                    </head>
                    <body>
                        <a href="../index.php?film=<?php echo $_GET['film'];?>">На головну</a>
                        <form name="edit-film" method="post" action="?action=edit-film&film=<?php echo $_GET['film'];?>">
                            <div><label for="name">Назва Фільму: </label><input type="text" name="name"
                                value="<?php echo $film->getName(); ?>"></div>
                            <div><label for="year">Рік виходу: </label><input type="text" name="year"
                                value="<?php echo $film->getYear(); ?>"></div>
                            <div><label for="country">Країна: </label><input type="text" name="country"
                                value="<?php echo $film->getCountry(); ?>"></div>
                            <div><input type="submit" name="ok" value="змінити"></div>
                        </form>    
                    </body>
                </html>
            <?php
        }

        public function showActorEditForm(\Model\Actor $actor){
            ?>
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Редагування актора</title>
                        <link rel="stylesheet" type="text/css" href="css/edit-actor-style.css">
                    </head>
                    <body>
                        <a href="index.php?film=<?php echo $_GET['film'];?>">На головну</a>
                            <form name="edit-student" method="post" action="?action=edit-actor&file=<?php echo $_GET['file'];?>&film=<?php echo $_GET['film'];?>">
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
            <?php
        }

        public function showActorCreateForm(){
            ?>
                <!DOCTYPE html>
                <html lang="en">
                    <head>
                        <title>Додавання актора</title>
                        <link rel="stylesheet" href="/css/edit-actor-style.css">
                    </head>
                    <body>
                    <a href="?film=<?php echo $_GET['film'];?>">На головну</a>
                        <form name="edit-student" method="post" action="?action=create-actor&film=<?php echo $_GET['film']; ?>">
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
            <?php
        }

        public function showLoginForm(){
            ?>
                <!DOCTYPE html>
                <html lang="en">
                    <head>
                        <title>Аутентифікації</title>
                        <link rel="stylesheet" type="text/css" href="/css/login-style.css">
                    </head>
                    <body>
                        <form method="post" action="?action=checkLogin">
                            <p>
                                <input align="center" type="text" name="username" placeholder="username">
                            </p>
                            <p>
                                <input type="password" name="password" placeholder="password">
                            </p>
                            <p>
                                <input type="submit" value="login">
                            </p>
                        </form>
                    </body>
                </html>
            <?php
        }

        public function showAdminForm($users){
            ?>
                <!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Адміністрування</title>
                    </head>
                    <body>
                        <header>
                            <a href="index.php">На головну</a>
                            <h1>Адміністуванян користувачів</h1>
                            <link rel="stylesheet" type="text/css" href="css/main-style.css">
                        </header>
                        <section>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Користувач</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $user): ?>
                                        <?php if($user->getUserName() != $_SESSION['user'] && $user->getUserName() != 'admin' && trim($user->getUserName()) != ''): ?>
                                            <tr>
                                                <td>
                                                    <a href = "action=edit-user-form&username=<?php echo $user->getUserName(); ?>"><?php echo $user->getUserName(); ?></a>
                                                </td>
                                            </tr>
                                        <?php endif ?>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </section>
                    </body>
                </html>
            <?php
        }

        public function showUserEditForm(\Model\User $user){
            ?>
                <!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" type="text/css" href="admin.css">
                        <title>Редагування користувача</title>
                    </head>
                    <body>
                        <a href="?action=admin">До списку користувачів</a>
                        <form name="edit-user" method="post" action="?action=edit-user&user=<?php echo $_GET['user']; ?>">
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
            <?php
        }
    }
?>