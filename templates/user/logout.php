<?php
session_start ();
unset($_SESSION['user']);
unset($_SESSION ['loggedin']);
session_destroy();
echo "You are logged out";

?>

