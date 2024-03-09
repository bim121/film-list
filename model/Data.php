<?php
    namespace Model;

    abstract class Data{
        const FILE = 0;

        private $error;
        private $user;

        public function setCurrentUser($userName){
            $this->user = $this->readUser($userName);
        }

        public function getCurrentUser(){
            return $this->user;
        }

        public function checkRight($object, $right){
            return $this->user->checkRight($object, $right);
        }

        public function readActors($filmId){
            if($this->user->checkRight('actor', 'view')){
                $this->error = "";
                return $this->getActors($filmId);
            }else{
                $this->error = "You have no permission to view actors";
                return false;
            }
        }
        protected abstract function getActors($filmId);

        public function readActor($filmId, $id){
            if($this->checkRight('actor', 'view')){
                $this->error = '';
                return $this->getActor($filmId, $id);
            } else{
                $this->error = "You have no permission to view actor";
                return false;
            }
        }
        protected abstract function getActor($filmId, $id);

        public function readFilms(){
            if($this->user->checkRight('film', 'view')){
                $this->error = "";
                return $this->getFilms();
            }else{
                $this->error = "You have no permission to view films";
                return false;
            }
        }
        protected abstract function getFilms();

        public function readFilm($id){
            if($this->checkRight('film', 'view')){
                $this->error = '';
                return $this->getFilm($id);
            } else{
                $this->error = "You have no permission to view film";
                return false;
            }
        }
        protected abstract function getFilm($id);

        public function readUsers(){
            if($this->user->checkRight('user', 'admin')){
                $this->error = "";
                return $this->getUsers();
            }else{
                $this->error = "You have no permission to administrate users";
                return false;
            }
        }
        protected abstract function getUsers();

        public function readUser($id){
            $this->error = '';
            return $this->getUser($id);
        }
        protected abstract function getUser($id);

        public function writeActor(Actor $actor){
            if($this->user->checkRight('actor', 'edit')){
                $this->error = "";
                $this->setActor($actor);
                return true;
            }else{
                $this->error = "You have no permission to edit actor";
                return false;
            }
        }
        protected abstract function setActor(Actor $actor);

        public function writeFilm(Film $film){
            if($this->user->checkRight('film', 'edit')){
                $this->error = "";
                $this->setFilm($film);
                return true;
            }else{
                $this->error = "You have no permission to edit film";
                return false;
            }
        }
        protected abstract function setFilm(Film $film);

        public function writeUser(User $user){
            if($this->user->checkRight('user', 'admin')){
                $this->error = "";
                $this->setUser($user);
                return true;
            }else{
                $this->error = "You have no permission to administrate users";
                return false;
            }
        }
        protected abstract function setUser(User $user);

        public function removeActor(Actor $actor){
            if($this->user->checkRight('actor', 'delete')){
                $this->error = "";
                $this->delActor($actor);
                return true;
            }else{
                $this->error = "You have no permission to delete actor";
                return false;
            }
        }
        protected abstract function delActor(Actor $actor);

        public function addActor(Actor $actor){
            if($this->user->checkRight('actor', 'create')){
                $this->error = "";
                $this->insActor($actor);
                return true;
            }else{
                $this->error = "You have no permission to create actor";
                return false;
            }
        }
        protected abstract function insActor(Actor $actor);

        public function removeFilm($filmId){
            if($this->user->checkRight('film', 'delete')){
                $this->error = "";
                $this->delFilm($filmId);
                return true;
            }else{
                $this->error = "You have no permission to delete film";
                return false;
            }
        }
        protected abstract function delFilm($filmId);

        public function addFilm(){
            if($this->user->checkRight('film', 'create')){
                $this->error = "";
                $this->insFilm();
                return true;
            }else{
                $this->error = "You have no permission to create film";
                return false;
            }
        }
        protected abstract function insFilm();

        public function getError(){
            if($this->error){
                return $this->error;
            }
            return false;
        }

        public static function makeModel($type){
            if($type == self::FILE){
                return new FileData();
            }
            return new FileData();
        }
    }
?>