<?php

// CLEAN URL: /u/USERNAME -> /user/profile.php?user_name=$1

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

echo "<h1>{$_GET['user_name']}</h1>";
