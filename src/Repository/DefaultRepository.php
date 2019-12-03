<?php
    namespace App\Repository;

    use App\Database\ConnectionHandler;
    use Exception;

    class DefaultRepository extends Repository
    {
        protected $tableName = 'league';
    }
?>