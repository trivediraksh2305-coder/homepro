<?php
session_start();

if(!isset($_SESSION['provider_id']) || $_SESSION['role'] != "provider"){
    header("Location: login.php");
    exit();
}
?>