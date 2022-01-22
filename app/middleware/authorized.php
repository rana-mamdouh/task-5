<?php
if(empty($_SESSION['user'])){
    header('location:login.php');die;
}