<?php

if(!session_id()) {
    session_start();
}

if(isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    unset($_SESSION['access_token']);
}

header('Location: login.php');
exit;