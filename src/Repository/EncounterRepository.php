<?php
    namespace App\Repository;

    use App\Database\ConnectionHandler;
    use Exception;

    class EncounterRepository extends Repository
    {
        protected $tableName = 'encounter';

        public function getMatchesByLeagueDateAndUser($leagueId, $currentDate, $userId){
            $query = "SELECT t.id AS id, t1.name AS hometeam, t2.name AS awayteam, t.homegoals AS homegoals, t.awaygoals AS awaygoals, e.id as begegnung_id FROM {$this->tableName} e
            JOIN team t1 ON t1.id = e.hometeam_id
            JOIN team t2 ON t2.id = e.awayteam_id
            LEFT JOIN tips t ON t.begegnung_id = e.id AND t.benutzer_id = ?
            WHERE t1.liga_id = ? AND t2.liga_id = ? AND e.datum > ? AND e.datum < ?";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $endDate = date('Y-m-d', strtotime($currentDate. ' + 8 days'));
            $statement->bind_param('iiiss', $userId, $leagueId, $leagueId, $currentDate, $endDate);

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