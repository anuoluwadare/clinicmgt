<?php
session_start();
header('Location: index.php');
$_SESSION = array(); 
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}
 session_destroy();
 




?>