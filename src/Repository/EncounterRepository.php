<?php
    namespace App\Repository;

    use App\Database\ConnectionHandler;
    use Exception;

    class EncounterRepository extends Repository
    {
        protected $tableName = 'encounter';
    }
?>