<?php

namespace App\Repository;

use App\Database\ConnectionHandler;
use Exception;

/**
 * Das UserRepository ist zuständig für alle Zugriffe auf die Tabelle "user".
 *
 * Die Ausführliche Dokumentation zu Repositories findest du in der Repository Klasse.
 */
class UserRepository extends Repository
{
    /**
     * Diese Variable wird von der Klasse Repository verwendet, um generische
     * Funktionen zur Verfügung zu stellen.
     */
    protected $tableName = 'user';

    /**
     * Erstellt einen neuen benutzer mit den gegebenen Werten.
     *
     * Das Passwort wird vor dem ausführen des Queries noch mit dem SHA1
     *  Algorythmus gehashed.
     *
     * @param $firstName Wert für die Spalte firstName
     * @param $lastName Wert für die Spalte lastName
     * @param $email Wert für die Spalte email
     * @param $password Wert für die Spalte password
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     */
    public function create($firstName, $lastName, $email, $password)
    {
        $resetPoints = 0;
        $query = "INSERT INTO $this->tableName (firstName, lastName, email, password, punkte) VALUES (?, ?, ?, sha2(?, 256), ?)";
        $emailCheck = "SELECT * FROM user WHERE email = ?";
        $statement = ConnectionHandler::getConnection()->prepare($emailCheck);
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();

        $res = mysqli_query(ConnectionHandler::getConnection(), $result);
        if(mysqli_num_rows($res) > 0) {
            echo "sladfj";
        } else {
            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('ssssi', $firstName, $lastName, $email, $password, $resetPoints);

            if (!$statement->execute()) {
             throw new Exception($statement->error);
            }
            return $statement->insert_id;
        }
    }

    public function loginCheck($email, $password) {
        $query = "SELECT id, email, password FROM user WHERE email = ? AND password = sha2(?, 256)";
        $email = $_POST ['email'];
        $password = $_POST ['password'];

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("ss", $email, $password);

        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
	        $row = $result->fetch_object();
	        $_SESSION['email'] = $row->email;
	        $_SESSION['loggedin'] = true;
	        header('Location: /');
        } else {
	        echo '<script language="javascript">';
            echo 'alert("E-Mail oder Passwort ist falsch.")';
            echo '</script>';
            
        }
    }

    public function logout() {
        session_start ();
        unset($_SESSION['user']);
        unset($_SESSION ['loggedin']);
        session_destroy();
        echo "You are logged out";
    }

    public function readTop20(){
        $query = "SELECT * FROM {$this->tableName} ORDER BY punkte DESC LIMIT 0, 20";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }

        return $rows;
    }
}
?>