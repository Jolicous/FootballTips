<?php

namespace App\Controller;

use App\Repository\EncounterRepository;
use App\Repository\DefaultRepository;
use App\Repository\MytipsRepository;
use App\View\View;

class LeagueController
{

    public function openLeague()
    {
        session_start();
        if (!isset($_SESSION['loggedin']) && !$_SESSION['loggedin'] == 1) {
            echo '<script language="javascript">';
            echo 'if(!alert("Du musst dich zuerst einloggen!")){window.location.href ="/user";}';
            echo '</script>'; 
        } else {
            $encounterRepository = new EncounterRepository();

            $view = new View('league/index');
            $leagueId = $_GET['id'];
            $view->leagueId = $leagueId;
            $view->title = $this->getLeagueName($leagueId);
            $view->heading = $this->getLeagueName($leagueId);
            $view->matches = $encounterRepository->getMatchesByLeagueDateAndUser($leagueId, date("Y-m-d"), 1);
            $tips = array();
            foreach($view->matches as $match){
                if(isset($match->homegoals) && isset($match->awaygoals)){
                    $tips[] = $match;
                }
            }
            $view->table = $this->loadTable($leagueId);
            $view->display();
        }
    }

    public function saveTips(){
        $encounterRepository = new EncounterRepository();
        $myTipsRepository = new MytipsRepository();

        $view = new View('league/index');
        $leagueId = $_POST['leagueId'];
        $view->title = $this->getLeagueName($leagueId);
        $view->heading = $this->getLeagueName($leagueId);
        $view->matches = $encounterRepository->getMatchesByLeagueDateAndUser($leagueId, date("Y-m-d"), 1);
        foreach($view->matches as $match){
            if(isset($match->id)){
                $myTipsRepository->updateById($match->id, $_POST["homegoals_$match->id"], $_POST["awaygoals_$match->id"]);
            }else{
                $myTipsRepository->createTip(1, $match->begegnung_id, $_POST["homegoals_$match->id"], $_POST["awaygoals_$match->id"]);
            }
        }
        $view->matches = $encounterRepository->getMatchesByLeagueDateAndUser($leagueId, date("Y-m-d"), 1);
        $tips = array();
        foreach($view->matches as $match){
            if(isset($match->homegoals) && isset($match->awaygoals)){
                $tips[] = $match;
            }
        }
        $view->table = $this->loadTable($leagueId);
        $view->display();
    }

    private function loadTable($leagueId){
        $defaultRepository = new DefaultRepository();

        return $defaultRepository->readLeagueById($leagueId);
    }

    private function getLeagueName($leagueId){
        $defaultRepository = new DefaultRepository();
        
        return $defaultRepository->readById($leagueId)->name;
    }
}