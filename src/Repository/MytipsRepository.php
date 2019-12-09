<?php
    namespace App\Repository;

    use App\Database\ConnectionHandler;
    use Exception;

    class MytipsRepository extends Repository
    {
        protected $tableName = 'tips';

        public function getTipsByUserId($benutzer_id){
            $query = "SELECT * FROM {$this->tableName} WHERE benutzer_id=?";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('i', $benutzer_id);

            $statement->execute();

            $result = $statement->get_result();
            if (!$result) {
                throw new Exception($statement->error);
            }

            $row = $result->fetch_object();

            $result->close();

            return $row;
        }
    }
?>