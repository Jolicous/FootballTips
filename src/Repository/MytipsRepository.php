<?php
    namespace App\Repository;

    use App\Database\ConnectionHandler;
    use Exception;

    class MytipsRepository extends Repository
    {
        protected $tableName = 'tips';

        public function getTipsByUserId($benutzer_id){
            $query = "SELECT t.id as id, t.homegoals as homegoals, t.awaygoals as awaygoals, t1.name as hometeam, t2.name as awayteam FROM {$this->tableName} t
            JOIN encounter e ON t.begegnung_id = e.id
            JOIN team t1 ON t1.id = e.hometeam_id
            JOIN team t2 ON t2.id = e.awayteam_id
            WHERE t.benutzer_id = ?";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('i', $benutzer_id);

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

        public function updateById($id, $homegoals, $awaygoals){
            $query = "UPDATE {$this->tableName} SET homegoals=?, awaygoals=? WHERE id=?";
            
            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('iii', $homegoals, $awaygoals, $id);
    
            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }
        }
    }
?>