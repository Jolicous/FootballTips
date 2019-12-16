<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\MytipsRepository;
use App\Repository\EncounterRepository;
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
            $this->calculateUserPoints();
            $view->bestlist = $userRepository->readTop20();
            $view->display();
        }
    }

    private function calculateUserPoints(){
        $mytipsRepository = new MytipsRepository();
        $encounterRepository = new EncounterRepository();
        $userRepository = new UserRepository();
        $tips = $mytipsRepository->readAll();
        $encounters = $encounterRepository->getEncountersAlreadyPlayed(date("Y-m-d"));
        foreach($tips as $tip){
            foreach($encounters as $encounter){
                if($encounter->id == $tip->begegnung_id){
                    $user = $userRepository->readById($tip->benutzer_id);
                    if($encounter->homegoals == $tip->homegoals){
                        $user->punkte = $user->punkte + 1;
                    }
                    
                    if($encounter->awaygoals == $tip->awaygoals){
                        $user->punkte = $user->punkte + 1;
                    }

                    if($tip->homegoals > $tip->awaygoals && $encounter->homegoals > $encounter->awaygoals){
                        $user->punkte = $user->punkte + 1;
                    }

                    if($tip->homegoals < $tip->awaygoals && $encounter->homegoals < $encounter->awaygoals){
                        $user->punkte = $user->punkte + 1;
                    }
                    $userRepository->updateUserPoints($user->id, $user->punkte);
                }
            }
        }
    }
}