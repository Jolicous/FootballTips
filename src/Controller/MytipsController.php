<?php

namespace App\Controller;

use App\Repository\MytipsRepository;
use App\View\View;


class MyTipsController
{

    public function index()
    {
        $mytipsRepository = new MytipsRepository();

        $view = new View('mytips/index');
        $view->title = 'Meine Tipps';
        $view->heading = 'Meine Tipps';
        $view->display();
    }
}
