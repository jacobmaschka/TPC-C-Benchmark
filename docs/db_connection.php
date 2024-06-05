<?php
    $host = getenv('host');
    $username = getenv('username');
    $password = getenv('password'); 
    $database_in_use = getenv('database_in_use');
    $mysqli = new mysqli($host, $username, $password, $database_in_use) or die ("Unable to connect");
?>
