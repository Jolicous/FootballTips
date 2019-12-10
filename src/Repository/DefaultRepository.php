<?php
    namespace App\Repository;

    use App\Database\ConnectionHandler;
    use Exception;

    class DefaultRepository extends Repository
    {
        protected $tableName = 'league';  

        public function readLeagueById($leagueId){
            $query = "SELECT t.name AS name, lt.tore AS tore, lt.gegentore AS gegentore, lt.punkte AS punkte FROM {$this->tableName} l
            JOIN league_team lt ON lt.liga_id = l.id
            JOIN team t ON t.id = lt.mannschaft_id
            WHERE l.id = ?
            ORDER BY lt.Punkte DESC, lt.tore - lt.gegentore DESC, lt.tore DESC, t.name";
    
            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('i', $leagueId);
    
            $statement->execute();
            
            $result = $statement->get_result();
            if (!$result) {
                throw new Exception($statement->error);
            }
    
            $rows = array();
            while ($row = $result->fetch_object()) {
                $rows[] = $row;
            }
    
            return $rows;
        }      
    }
?>