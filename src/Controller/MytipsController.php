<?php

namespace App\Controller;

use App\Repository\MytipsRepository;
use App\Repository\EncounterRepository;
use App\View\View;


class MyTipsController
{

    public function index()
    {
        $mytipsRepository = new MytipsRepository();
        $encounterRepository = new EncounterRepository();

        $view = new View('mytips/index');
        $view->title = 'Meine Tipps';
        $view->heading = 'Meine Tipps';
        $tips = $mytipsRepository->getTipsByUserId(1);
        $tips_encounters = array();
        if(isset($tips)){
            for($i = 0; $i < count($tips); $i++){
                array_push($tips_encounters, array($tips[$i], $encounterRepository->readById($tips[$i]->begegnung_id)));
            }
        }
        $view->tips = $tips_encounters;
        $view->display();
    }
}
