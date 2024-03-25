<?php
    namespace Controller;

    use Model\Data;
    use View\FilmListView;

    class FilmListApp{
        private $model;
        private $view;

        public function __construct($modelType, $viewType){
            session_start();
            $this->model = Data::makeModel($modelType);
            $this->view = FilmListView::makeView($viewType);
        }

        public function checkAuth(){
            if($_SESSION['user']){
                $this->model->setCurrentUser($_SESSION['user']);
                $this->view->setCurrentUser($this->model->getCurrentUser());
            } else{
                header('Location: ?action=login');
            }
        }

        public function run(){
            if(!in_array($_GET['action'], array('login', 'checkLogin'))){
                $this->checkAuth();
            }
            if($_GET['action']){
                switch($_GET['action']){
                    case 'login':
                        $this->showLoginForm();
                        break;
                    case 'checkLogin':
                        $this->checkLogin();
                        break;
                    case 'logout':
                        $this->logout();
                        break;
                    case 'create-film':
                        $this->createFilm();
                        break;
                    case 'edit-film-form':
                        $this->showEditFilmForm();
                        break;
                    case 'edit-film':
                        $this->editFilm();
                        break;
                    case 'delete-film':
                        $this->deleteFilm();
                        break;
                    case 'create-actor-form':
                        $this->showCreateActorForm();
                        break;
                    case 'create-actor':
                        $this->createActor();
                        break;
                    case 'edit-actor-form':
                        $this->showEditActorForm();
                        break;
                    case 'edit-actor':
                        $this->editActor();
                        break;
                    case 'delete-actor':
                        $this->deleteActor();
                        break;
                    case 'admin':
                        $this->adminUser();
                        break;
                    case 'edit-user-form':
                        $this->showEditUserForm();
                        break;
                    case 'edit-user':
                        $this->editUser();
                        break;
                    default:
                        $this->showMainForm();
                }
            } else{
                $this->showMainForm();
            }
        }

        private function showLoginForm(){
            $this->view->showLoginForm();
        }

        private function checkLogin(){
            if($user = $this->model->readUser($_POST['username'])){
                if($user->checkPassword($_POST['password'])){
                    session_start();
                    $_SESSION['user'] = $user->getUserName();
                    header('Location: index.php');
                }
            }
        }
        
        private function logout(){
            unset($_SESSION['user']);
            header('Location: ?action=login');
        }

        private function showMainForm(){
            $films = array();
            if($this->model->checkRight('film', 'view')){
                $films = $this->model->readFilms();
            }
            $film = new \Model\Film();
            if($_GET['film'] && $this->model->checkRight('film', 'view')){
                $film = $this->model->readFilm($_GET['film']);
            }
            $actors = array();
            if($_GET['film'] && $this->model->checkRight('actor', 'view')){
                $actors = $this->model->readActors($_GET['film']);
            }
            $this->view->showMainForm($films, $film, $actors);
        }

        private function createFilm(){
            if(!$this->model->addFilm()){
                die($this->model->getError());
            }else{
                header("Location: ../index.php?");
            }
        }

        private function showEditFilmForm(){
            if(!$film = $this->model->readFilm($_GET['film'])){
                die($this->model->getError());
            }
            $this->view->showFilmEditForm($film);
        }

        private function editFilm(){
            if(!$this->model->writeFilm((new \Model\Film())
                ->setId($_GET['film'])
                ->setName($_POST['name'])
                ->setYear($_POST['year'])
                ->setCountry($_POST['country'])
            )) {
                die($this->model->getError());
            } else {
                header('Location: ../index.php?film=' . $_GET['film']);
            }
        }

        private function deleteFilm(){
            if(!$this->model->removeFilm($_GET['film'])){
                die($this->model->getError());
            }else{
                header('Location: index.php');
            }
        }

        private function showEditActorForm(){
            $actor = $this->model->readActor($_GET['film'], $_GET['file']);
            $this->view->showActorEditForm($actor);
        }

        private function editActor(){
            $actor = (new \Model\Actor())
                ->setId($_GET['file'])
                ->setFilmId($_GET['film'])
                ->setName($_POST['actor_name'])
                ->setRoles($_POST['actor_roles'])
                ->setEpisode($_POST['actor_episodes'])
                ->setWorldClass($_POST['actor_worldClass']);
            if(!$this->model->writeActor($actor)){
                die($this->model->getError());
            }else{
                header('Location: ../index.php?film=' . $_GET['film']);
            }
        }

        private function showCreateActorForm(){
            $this->view->showActorCreateForm();
        }

        private function createActor(){
            $actor = (new \Model\Actor())
            ->setFilmId($_GET['film'])
            ->setName($_POST['actor_name'])
            ->setRoles($_POST['actor_roles'])
            ->setEpisode($_POST['actor_episodes'])
            ->setWorldClass($_POST['actor_worldClass']);
            if(!$this->model->addActor($actor)){
                die($this->model->getError());
            }else{
                header('Location: ../index.php?film=' . $_GET['film']);
            }
        }

        private function deleteActor(){
            $actor = (new \Model\Actor())->setId($_GET['file'])->setFilmId($_GET['film']);
            if(!$this->model->removeActor($actor)){
                die($this->model->getError());
            }else{
                header('Location: index.php?film=' . $_GET['film']);
            }
        }

        private function adminUser(){
            $users = $this->model->readUsers();
            $this->view->showAdminForm($users);
        }

        private function showEditUserForm(){
            if(!$user = $this->model->readUser($_GET['username'])){
                die($this->model->getError());
            }
            $this->view->showUserEditForm($user);
        }

        private function editUser(){
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
            if(!$this->model->writeUser($user)){
                die($this->model->getError());
            } else{
                header('Location: index.php');
            }
        }
    }
?>