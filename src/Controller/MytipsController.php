<?php

namespace App\Controller;

use App\Repository\MytipsRepository;
use App\Repository\EncounterRepository;
use App\Repository\UserRepository;
use App\View\View;


class MyTipsController
{

    public function index()
    {
        session_start();
        print_r($_SESSION);
        if (!isset($_SESSION['loggedin']) && !$_SESSION['loggedin'] == 1) {
            echo '<script language="javascript">';
            echo 'if(!alert("Du musst dich zuerst einloggen!")){window.location.href ="/user";}';
            echo '</script>'; 
        } else {
            $view = new View('mytips/index');
            $this->loadTips($view);
            $view->title = 'Meine Tipps';
            $view->heading = 'Meine Tipps';
            $view->display();
        }
    }

    public function savetips(){
        $mytipsRepository = new MytipsRepository();

        $view = new View('mytips/index');
        $this->loadTips($view);
        foreach($view->tips as $tip){
            $mytipsRepository->updateById($tip->id, $_POST["homegoals_$tip->id"], $_POST["awaygoals_$tip->id"]);
        }
        $this->loadTips($view);
        $view->title = 'Meine Tipps';
        $view->heading = 'Meine Tipps';
        $view->display();
    }

    public function deleteEntry(){
        $mytipsRepository = new MytipsRepository();

        $view = new View('mytips/index');
        $view->title = 'Meine Tipps';
        $view->heading = 'Meine Tipps';
        $mytipsRepository->deleteById($view->tips[$_GET['index']]->id); 
        $this->loadTips($view);    
        $view->display();
    }

    private function loadTips($view){
        session_start();
        $mytipsRepository = new MytipsRepository();

        $view->tips = $mytipsRepository->getTipsByUserId($_SESSION['id']);
    }
}
