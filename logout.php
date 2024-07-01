<?php
    include "login.php";
    session_start();

    unset($_SESSION["Admin_Pin"]);
    unset($_SESSION["PassWord"]);

    session_destroy();
    echo "<script>window.open('login.php','_self');</script>";
?>