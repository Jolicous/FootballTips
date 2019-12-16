<?php

namespace App\Repository;

use App\Database\ConnectionHandler;
use Exception;

class UserRepository extends Repository
{

    protected $tableName = 'user';

    public function create($firstName, $lastName, $email, $password)
    {
        $query = "INSERT INTO $this->tableName (firstName, lastName, email, password, punkte) VALUES (?, ?, ?, sha2(?, 256), ?)";
        $emailCheck = "SELECT * FROM user WHERE email = '$email'";
        $res = mysqli_query(ConnectionHandler::getConnection(), $emailCheck);
        if(mysqli_num_rows($res) > 0) {
            echo '<script language="javascript">';
            echo 'if(!alert("Diese Email wird schon verwendet!")){window.location.href ="/user";}';
            echo '</script>'; 
        } else {
            $points = 0;
            $statement = ConnectionHandler::getConnection();
            $escapedFirstName = $statement->escape_string($firstName);
            $escapedLastName = $statement->escape_string($lastName);
            $escapedEmail = $statement->escape_string($email);
            $statement = $statement->prepare($query);
            $statement->bind_param('ssssi', $escapedFirstName, $escapedLastName, $escapedEmail, $password, $points);

            if (!$statement->execute()) {
             throw new Exception($statement->error);
            }
            return $statement->insert_id;
        }
    }

    public function loginCheck($email, $password) {
        session_start();
        $query = "SELECT id, email, password FROM user WHERE email = ? AND password = sha2(?, 256)";

        $statement = ConnectionHandler::getConnection();
        $email = $statement->escape_string($_POST['email']);
        $password = $_POST['password'];
        $statement = $statement->prepare($query);
        $statement->bind_param("ss", $email, $password);

        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_object();
            $_SESSION['id'] = $row->id;
	        $_SESSION['email'] = $row->email;
	        $_SESSION['loggedin'] = true;
	        header('Location: /');
        } else {
	        echo '<script language="javascript">';
            echo 'if(!alert("Email oder Passwort ist falsch!")){window.location.href ="/user";}';
            echo '</script>';            
        }
    }

    public function change($id, $firstName, $lastName, $email, $password) {
        $query = "UPDATE user SET firstname=?, lastname=?, email=?, password=sha2(?, 256) where id=?";
        $statement = ConnectionHandler::getConnection();
        $escapedFirstName = $statement->escape_string($firstName);
        $escapedLastName = $statement->escape_string($lastName);
        $escapedEmail = $statement->escape_string($email);
        $statement = $statement->prepare($query);
        $statement->bind_param("ssssi", $escapedFirstName, $escapedLastName, $escapedEmail, $password, $id);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
           }
    }

    public function getUserInfosById($id) {
        $query = "SELECT * from user where id=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        
        $result = $statement->get_result();
         if (!$result) {
              throw new Exception($statement->error);
        }
        $row = $result->fetch_object();

        $result->close();

        return $row;

    }

    public function updateUserPoints($id, $points){
        $query = "UPDATE user SET punkte = ? WHERE id = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("ii", $points, $id);
        $statement->execute();

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }

    public function logout() {
        session_start ();
        unset($_SESSION['user']);
        unset($_SESSION ['loggedin']);
        session_destroy();
            echo '<script language="javascript">';
            echo 'if(!alert("Ausgeloggt")){window.location.href ="/user";}';
            echo '</script>';   
    }

    
    public function readTop20(){
        $query = "SELECT * FROM {$this->tableName} ORDER BY punkte DESC LIMIT 0, 20";

        $statement = ConnectionHandler::getConnection()->prepare($query);
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