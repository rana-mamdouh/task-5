<?php
session_start();
unset($_SESSION['user']);
if(isset($_COOKIE['remember_me'])){
    setcookie('remember_me','',time()-1,'/');
}

header('location:../../login.php');