<?php

namespace App\Controller;

use App\Repository\EncounterRepository;
use App\Repository\DefaultRepository;
use App\Repository\MytipsRepository;
use App\Repository\UserRepository;
use App\View\View;

class LeagueController
{

    //gets all matches and prepares the whole view.
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
            $view->matches = $encounterRepository->getMatchesByLeagueDateAndUser($leagueId, date("Y-m-d"), $_SESSION['id']);
            $tips = array();
            foreach($view->matches as $match){
                if(isset($match->homegoals) && isset($match->awaygoals)){
                    $tips[] = $match;
                }
            }
            $view->table = $this->loadTable($leagueId);
            $userRepository = new UserRepository();
            $view->user = $userRepository->getUserInfosById($_SESSION['id']);
            $view->display();
        }
    }

    //saves the tips from the user
    public function saveTips(){
        session_start();
        $encounterRepository = new EncounterRepository();
        $myTipsRepository = new MytipsRepository();

        $view = new View('league/index');
        $leagueId = $_POST['leagueId'];
        $view->title = $this->getLeagueName($leagueId);
        $view->heading = $this->getLeagueName($leagueId);
        $view->matches = $encounterRepository->getMatchesByLeagueDateAndUser($leagueId, date("Y-m-d"), $_SESSION['id']);
        foreach($view->matches as $match){
            if(isset($match->id)){
                $myTipsRepository->updateById($match->id, $_POST["homegoals_$match->id"], $_POST["awaygoals_$match->id"]);
            }else{
                $myTipsRepository->createTip($_SESSION['id'], $match->begegnung_id, $_POST["homegoals_$match->id"], $_POST["awaygoals_$match->id"]);
            }
        }
        $view->matches = $encounterRepository->getMatchesByLeagueDateAndUser($leagueId, date("Y-m-d"), $_SESSION['id']);
        $tips = array();
        foreach($view->matches as $match){
            if(isset($match->homegoals) && isset($match->awaygoals)){
                $tips[] = $match;
            }
        }
        $view->table = $this->loadTable($leagueId);
        $view->display();
    }

    //loads the table from the league
    private function loadTable($leagueId){
        $defaultRepository = new DefaultRepository();

        return $defaultRepository->readLeagueById($leagueId);
    }

    //gets the league name
    private function getLeagueName($leagueId){
        $defaultRepository = new DefaultRepository();

        return $defaultRepository->readById($leagueId)->name;
    }
}