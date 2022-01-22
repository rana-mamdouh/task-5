<?php
if(!empty($_SESSION['user'])){
    header('location:index.php');die;
}
