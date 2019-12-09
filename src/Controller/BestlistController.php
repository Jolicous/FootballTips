<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\View\View;

class BestlistController
{
    public function index()
    {
        $userRepository = new UserRepository();
        $view = new View('bestlist/index');
        $view->title = 'Bestenliste';
        $view->heading = 'Bestenliste';
        $view->bestlist = $userRepository->readTop20();
        $view->display();
    }
}