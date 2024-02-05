<?php 

    namespace Model;

    class Film{
        private $id;
        private $name;
        private $year;
        private $country;

        public function setId($id){
            $this->id = $id;
            return $this;
        }
        public function getId(){
            return $this->id;
        }
        public function setName($name){
            $this->name = $name;
            return $this;
        }
        public function getName(){
            return $this->name;
        }
        public function setYear($year){
            $this->year = $year;
            return $this;
        }
        public function getYear(){
            return $this->year;
        }
        public function setCountry($country){
            $this->country = $country;
            return $this;
        }
        public function getCountry(){
            return $this->country;
        }
    }
?>