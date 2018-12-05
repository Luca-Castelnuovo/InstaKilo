<?php

// Generate secure random tkns
function gen($length = 32)
{
    return bin2hex(random_bytes($length / 2));
}


// Generate and set CSRF token
function csrf_gen()
{
    if (isset($_SESSION['CSRFtoken'])) {
        return $_SESSION['CSRFtoken'];
    } else {
        $_SESSION['CSRFtoken'] = gen(32);
        return $_SESSION['CSRFtoken'];
    }
}


// Validate CSRF token
function csrf_val($CSRFtoken)
{
    if (!isset($_SESSION['CSRFtoken'])) {
        redirect('/index.php', 'CSRF Error');
    }
    if (!(hash_equals($_SESSION['CSRFtoken'], $CSRFtoken))) {
        redirect('/index.php', 'CSRF Error');
    } else {
        unset($_SESSION['CSRFtoken']);
    }
}
