<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\View\View;

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    //shows the right view depending if you're logged in or not
    public function index()
    {
        session_start ();
        $userRepository = new UserRepository();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
            $view = new View('user/change');
            $view->title = 'Bearbeiten';
            $view->heading = 'Bearbeiten';
                echo "im isset";
                $view->user = $userRepository->getUserInfosById($_SESSION['id']);

            
        } else {
            $view = new View('user/login');
            $view->title = 'Anmelden';
            $view->heading = 'Anmelden';
            $view->display();
            $view = new View('user/create');
            $view->title = 'Registrieren';
            $view->heading = 'Registrieren';
            
        }
        $view->display();
    }

    //creates a user
    public function doCreate()
    {
        $message = "";
        if (isset($_POST['send'])) {
            $firstName = htmlentities($_POST['fname']);
            $lastName = htmlentities($_POST['lname']);
            $email = htmlentities($_POST['email']);
            $password = $_POST['password'];

            $userRepository = new UserRepository();
            $message = $userRepository->create($firstName, $lastName, $email, $password);
        
        }

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        if(strlen($message) > 10){
            $view = new View('user/login');
            $view->title = 'Anmelden';
            $view->heading = 'Anmelden';
            $view->message = $message;
            $view->display();
            $view = new View('user/create');
            $view->title = 'Registrieren';
            $view->heading = 'Registrieren';
        }else{
            header('Location: /user');
        }
    }

    //is the login for the website
    public function doLogin()
    {
        if (isset($_POST['send'])) {
            $email = htmlentities($_POST['email']);
            $password = $_POST['password'];
                
            $userRepository = new UserRepository();
            $userRepository->loginCheck($email, $password);
        }
        
    }

    //changes the user who is logged in
    public function doChange() {
        session_start();
        if (isset($_SESSION['id']) && isset($_POST['id']) && $_SESSION['id'] == $_POST['id'])
        {
            if (isset($_POST['change'])) {
                $id = $_POST['id'];
                $firstName = htmlentities($_POST['fname']);
                $lastName = htmlentities($_POST['lname']);
                $email = htmlentities($_POST['email']);
                $password = $_POST['password'];
                
                $userRepository = new UserRepository();
                $userRepository->change($id, $firstName, $lastName, $email, $password);
            }
            $this->doDelete();
            header('Location: /user');
        }
            $this->doLogout();
        
    }
    //is the logout 
    public function doLogout() {
        if (isset($_POST['logout'])) {
            $userRepository = new UserRepository();
            $userRepository->logout();
        }
    }
    //deletes the user who is logged in
    public function doDelete(){
        if (isset($_POST['delete'])) {
            $userRepository = new UserRepository();
            $userRepository->deleteById($_POST['id']);
            $userRepository->logout();
        }
    }
}
