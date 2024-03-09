<?php

namespace View;

abstract class FilmListView{
    const SIMPLEVIEW = 0;
    private $user;

    public function setCurrentUser(\Model\User $user){
        $this->user = $user;
    }
    public function checkRight($object, $right){
        return $this->user->checkRight($object, $right);
    }

    public abstract function showMainForm($films, \Model\Film $film, $actors);
    public abstract function showFilmEditForm(\Model\Film $film);
    public abstract function showActorEditForm(\Model\Actor $actor);
    public abstract function showActorCreateForm();
    public abstract function showLoginForm();
    public abstract function showAdminForm($users);
    public abstract function showUserEditForm(\Model\User $user);

    public static function makeView($type){
        if($type == self::SIMPLEVIEW){
            return new MyView();
        }
        return new MyView();
    }

}

?>