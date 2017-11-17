<?php

if(!session_id()) {
    session_start();
}

if(isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datos de Facebook</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <?php if($loggedIn): ?>
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="index.php">Home</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                <?php else: ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="login.php">Login</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <div class="container">