<?php

namespace App\Controller;

use App\Repository\MytipsRepository;
use App\Repository\EncounterRepository;
use App\View\View;


class MyTipsController
{

    public function index()
    {
        session_start();
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
        $this->loadTips($view);
        $mytipsRepository->deleteById($view->tips[htmlentities($_GET['index'])]->id); 
        $this->loadTips($view);    
        $view->display();
    }

    private function loadTips($view){
        if (isset($_SESSION['id']) && isset($_POST['id']) && $_SESSION['id'] == $_POST['id']) {
            $id = $_POST['id'];
        }
        $mytipsRepository = new MytipsRepository();

        $view->tips = $mytipsRepository->getTipsByUserId($id);
    }
}
