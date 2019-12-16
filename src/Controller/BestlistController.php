<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\View\View;

class BestlistController
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['loggedin']) && !$_SESSION['loggedin'] == 1) {
            echo '<script language="javascript">';
            echo 'if(!alert("Du musst dich zuerst einloggen!")){window.location.href ="/user";}';
            echo '</script>'; 
        } else {
            $userRepository = new UserRepository();
            $view = new View('bestlist/index');
            $view->title = 'Bestenliste';
            $view->heading = 'Bestenliste';
            $view->bestlist = $userRepository->readTop20();
            $view->display();
        }
    }
}