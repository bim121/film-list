<?php

    namespace Model;

    class Actor{
        private $id;
        private $name;
        private $roles;
        private $episode;
        private $worldClass;
        private $filmId;

        public function getId(){
            return $this->id;
        }
        public function setId($id){
            $this->id = $id;
            return $this;
        }
        public function getName(){
            return $this->name;
        }
        public function setName($name){
            $this->name = $name;
            return $this;
        }
        public function getRoles(){
            return $this->roles;
        }
        public function setRoles($roles){
            $this->roles = $roles;
            return $this;
        }
        public function getEpisode(){
            return $this->episode;
        }
        public function setEpisode($episode){
            $this->episode = $episode;
            return $this;
        }
        public function getWorldClass(){
            return $this->worldClass;
        }
        public function setWorldClass($worldClass){
            $this->worldClass = $worldClass;
            return $this;
        }
        public function getFilmId(){
            return $this->filmId;
        }
        public function setFilm($filmId){
            $this->filmId = $filmId;
            return $this;
        }
    }
?>