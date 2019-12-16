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
            $view->potentialTable = $this->loadPotentialTable($leagueId, $tips);
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
        $view->potentialTable = $this->loadPotentialTable($leagueId, $tips);
        $view->display();
    }

    private function loadTable($leagueId){
        $defaultRepository = new DefaultRepository();

        return $defaultRepository->readLeagueById($leagueId);
    }

    private function loadPotentialTable($leagueId, $tips){
        $table = $this->loadTable($leagueId);
        foreach($tips as $tip){
            // if($tip->homegoals > $tip->awaygoals){
            //     $table[$tip->hometeam]->punkte = $table[$tip->hometeam]->punkte + 3;
            //     $table[$tip->hometeam]->tore = $table[$tip->hometeam]->tore + $tip->homegoals;
            //     $table[$tip->hometeam]->gegentore = $table[$tip->hometeam]->gegentore +  $tip->awaygoals;
            //     $table[$tip->awayteam]->tore = $table[$tip->awayteam]->tore + $tip->awaygoals;
            //     $table[$tip->awayteam]->gegentore = $table[$tip->awayteam]->gegentore +  $tip->homegoals;
            // }else if($tip->homegoals < $tip->awaygoals){
            //     $table[$tip->awayteam]->punkte = $table[$tip->awayteam]->punkte + 3;
            //     $table[$tip->hometeam]->tore = $table[$tip->hometeam]->tore + $tip->homegoals;
            //     $table[$tip->hometeam]->gegentore = $table[$tip->hometeam]->gegentore +  $tip->awaygoals;
            //     $table[$tip->awayteam]->tore = $table[$tip->awayteam]->tore + $tip->awaygoals;
            //     $table[$tip->awayteam]->gegentore = $table[$tip->awayteam]->gegentore +  $tip->homegoals;
            // }else{
            //     $table[$tip->hometeam]->punkte = $table[$tip->hometeam]->punkte + 1;
            //     $table[$tip->awayteam]->punkte = $table[$tip->awayteam]->punkte + 1;
            //     $table[$tip->hometeam]->tore = $table[$tip->hometeam]->tore + $tip->homegoals;
            //     $table[$tip->hometeam]->gegentore = $table[$tip->hometeam]->gegentore +  $tip->awaygoals;
            //     $table[$tip->awayteam]->tore = $table[$tip->awayteam]->tore + $tip->awaygoals;
            //     $table[$tip->awayteam]->gegentore = $table[$tip->awayteam]->gegentore +  $tip->homegoals;
            // }
            echo $tip->hometeam;
            echo $table['Manchester United'];
        }
        return $table;
    }

    private function getLeagueName($leagueId){
        $defaultRepository = new DefaultRepository();
        
        return $defaultRepository->readById($leagueId)->name;
    }
}