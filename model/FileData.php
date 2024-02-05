<?php 

namespace Model;

class FileData extends Data{
    const DATA_PATH = __DIR__ . '/../data/';
    const ACTR_FILE_TEMPLATE = '/^actor-\d\d.txt\z/';
    const FILM_FILE_TEMPLATE = '/^film-\d\d\z/';
    
    protected function getActors($filmId){
        $Actors = array();
        $conts = scandir(self::DATA_PATH . $filmId);
        foreach ($conts as $node){
            if(preg_match(self::ACTR_FILE_TEMPLATE, $node)){
                $Actors[] = $this->getActor($filmId, $node);
            }
        }
        return $Actors;
    }
    protected function getActor($filmId, $id){
        $f = fopen(self::DATA_PATH . $filmId . "/" . $id, 'r');
        $rowStr = fgets($f);
        $rowArr = explode(";", $rowStr);
        $Actor = (new Actor())
            ->setId($id)
            ->setName($rowArr[0])
            ->setRoles($rowArr[1])
            ->setEpisode($rowArr[2])
            ->setWorldClass($rowArr[3]);
        fclose($f);
        return $Actor;
    }
    protected function getFilms(){
        $films = array();
        $conts = scandir(self::DATA_PATH);
        foreach($conts as $node){
            if(preg_match(self::FILM_FILE_TEMPLATE, $node)){
                $films[] = $this->getFilm($node);
            }
        }
        return $films;
    }
    protected function getFilm($id){
        $f = fopen(self::DATA_PATH . $id . "/film.txt", "r");
        $fStr = fgets($f);
        $fArr = explode(";", $fStr);
        fclose($f);
        $film = (new Film())
            ->setId($id)
            ->setName($fArr[0])
            ->setYear($fArr[1])
            ->setCountry($fArr[2]);
        return $film;
    }
    protected function getUsers(){
        $users = array();
        $f = fopen(self::DATA_PATH . "users.txt", 'r');
        while(!feof($f)){
            $rowStr = fgets($f);
            $rowArr = explode(";", $rowStr);
            if(count($rowArr) == 3){
                $user = (new User())
                    ->setUserName($rowArr[0])
                    ->setPassword($rowArr[1])
                    ->setRights(substr($rowArr[2], 0, 9));
                $users[] = $user;
            }
        }
        fclose($f);
        return $users;
    }
    protected function getUser($id){
        $users = $this->getUsers();
        foreach($users as $user){
            if($user->getUserName() == $id){
                return $user;
            }
        }
        return false;
    }
    protected function setActor(Actor $actor){
        $f = fopen(self::DATA_PATH . $actor->getFilmId() . "/" . $actor->getId(), 'w');
        $fArr = array($actor->getName(), $actor->getRoles(), $actor->getEpisode(), $actor->getWorldClass(),);
        $fStr = implode(";", $fArr);
        fwrite($f, $fStr);
        fclose($f);

    }
    protected function delActor(Actor $actor){
        unlink(self::DATA_PATH . $actor->getFilmId() . "/" . $actor->getId());
    }
    protected function insActor(Actor $actor){
        $path = self::DATA_PATH . $actor->getFilmId();
        $conts = scandir($path);
        $i = 0;
        foreach($conts as $node){
            if(preg_match(self::ACTR_FILE_TEMPLATE, $node)){
                $last_file = $node;
            }
        }
        $file_index = (String)(((int)substr($last_file, -6, 2)) + 1);
        if(strlen($file_index) == 1){
            $file_index = "0" . $file_index;
        }
        $newFileName = "actor-" . $file_index . ".txt";

        $actor->setId($newFileName);
        $this->setActor($actor);
    }
    protected function setFilm(Film $film){
        $f = fopen(self::DATA_PATH . $film->getId() . "/film.txt", "w");
        $fArr = array($film->getName(), $film->getYear(), $film->getCountry(), );
        $fStr = implode(";", $fArr);
        fwrite($f, $fStr);
        fclose($f);
    }
    protected function setUser(User $user){
        $users = $this->getUsers();
        $found = false;
        foreach ($users as $key => $oneUser){
            if($user->getUserName() == $oneUser->getUserName()){
                $found = true;
                break;
            }
        }
        if($found){
            $users[$key] = $user;
            $f = fopen(self::DATA_PATH . "users.txt", "w");
            foreach($users as $oneUser){
                $fArr = array($oneUser->getUserName(), $oneUser->getPassword(), $oneUser->getRights() . "\r\n",);
                $fStr = implode(";", $fArr);
                fwrite($f, $fStr);
            }
            fclose($f);
        }
    }
    protected function delFilm($filmId){
        $dirName = self::DATA_PATH . $filmId;
        $conts = scandir($dirName);
        $i = 0;
        foreach($conts as $node){
            @unlink($dirName . '/' . $node);
        }
        @rmdir($dirName);
    }
    protected function insFilm(){
        $path = self::DATA_PATH;
        $conts = scandir($path);
        foreach($conts as $node){
            if(preg_match(self::FILM_FILE_TEMPLATE, $node)){
                $last_film = $node;
            }
        }
        $film_index = (String)(((int)substr($last_film, -1, 2)) + 1);
        if(strlen($film_index) == 1){
            $film_index = "0" . $film_index;
        }
        $newFilmName = "film-" . $film_index;

        mkdir($path . $newFilmName);
        $f = fopen($path . $newFilmName . "/film.txt", "w");
        fwrite($f, "New; ; ");
        fclose($f);
    }
}

?>