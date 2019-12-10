<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\View\View;

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    public function index()
    {
        session_start ();
        $userRepository = new UserRepository();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $view = new View('user/change');
            $view->title = 'Bearbeiten';
            $view->heading = 'Bearbeiten';
            $view->display();
        } else {
            $view = new View('user/login');
            $view->title = 'Anmelden';
            $view->heading = 'Anmelden';
            $view->display();
            $view = new View('user/create');
            $view->title = 'Registrieren';
            $view->heading = 'Registrieren';
            $view->display();
        }
    }

    public function doCreate()
    {
        if (isset($_POST['send'])) {
            $firstName = $_POST['fname'];
            $lastName = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userRepository = new UserRepository();
            $userRepository->create($firstName, $lastName, $email, $password);
        
        }

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        header('Location: /user');
    }

    public function doLogin()
    {
        if (isset($_POST['send'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
                
            $userRepository = new UserRepository();
            $userRepository->loginCheck($email, $password);
        }
        
    }

    public function doLogout() {
        $userRepository = new UserRepository();
        $userRepository->logout();
    }

    public function delete()
    {
        $userRepository = new UserRepository();
        $userRepository->deleteById($_GET['id']);

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        header('Location: /user');
    }
}
