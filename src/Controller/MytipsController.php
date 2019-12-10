<?php

namespace App\Controller;

use App\Repository\MytipsRepository;
use App\Repository\EncounterRepository;
use App\View\View;


class MyTipsController
{

    public function index()
    {
        $view = new View('mytips/index');
        $this->loadTips($view);
        $view->title = 'Meine Tipps';
        $view->heading = 'Meine Tipps';
        $view->display();
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
        $mytipsRepository->deleteById($view->tips[$_GET['index']]->id); 
        $this->loadTips($view);    
        $view->display();
    }

    private function loadTips($view){
        $mytipsRepository = new MytipsRepository();

        $view->tips = $mytipsRepository->getTipsByUserId(1);
    }
}
