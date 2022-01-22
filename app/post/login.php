<?php
session_start();
if(!isset($_POST['login'])){
    header('location:../../layouts/errors/404.php');die;
}
include_once "../requests/Validation.php";
include_once "../models/User.php";

$emailPattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
$email = new Validation('email', $_POST['email']);
$check = $email->checkIfSuccessForLogin($emailPattern);
$_SESSION['errors']['email'] = $check['errors'];
$checkSuccess['email'] = $check['success'];

$passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
$password = new Validation('password', $_POST['password']);
$check = $password->checkIfSuccessForLogin($passwordPattern);
$_SESSION['errors']['password'] = $check['errors'];
$checkSuccess['password'] = $check['success'];

Validation::checkIfSuccessForAllAndLogIn($checkSuccess);


header('location:../../login.php');



