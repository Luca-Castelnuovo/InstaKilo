<?php

session_start();

$GLOBALS['config'] = require $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

require $_SERVER['DOCUMENT_ROOT'] . '/includes/oauth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/security.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/sql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/template.php';

// External
require '/var/www/logs.lucacastelnuovo.nl/public_html/logs.php';
// log_action('7', 'service.test', $_SERVER["REMOTE_ADDR"], 'USER_ID');

$provider = new OAuth([
    'clientID'                => $GLOBALS['config']->client->id,
    'clientSecret'            => $GLOBALS['config']->client->secret,
    'redirectUri'             => 'https://instakilo.lucacastelnuovo.nl/',
    'urlAuthorize'            => 'https://accounts.lucacastelnuovo.nl/auth/authorize',
    'urlAccessToken'          => 'https://accounts.lucacastelnuovo.nl/auth/token',
]);


function redirect($to, $alert = null)
{
    !isset($alert) ?: alert_set($alert);
    header('location: ' . $to);
    exit;
}


function alert_set($alert)
{
    $_SESSION['alert'] = $alert;
}

function alert_display()
{
    if (isset($_SESSION['alert']) && !empty($_SESSION['alert'])) {
        echo "<script>M.toast({html: '{$_SESSION['alert']}'})</script>";
        unset($_SESSION['alert']);
    }
}


function response($success, $message = null, $extra = null)
{
    $output = ["success" => $success, "CSRFtoken" => csrf_gen()];

    if (isset($message) && !empty($message)) {
        if ($success) {
            $output = array_merge($output, ["message" => $message]);
        } else {
            $output = array_merge($output, ["error" => $message]);
        }
    }

    if (!empty($extra)) {
        $output = array_merge($output, $extra);
    }

    header('Content-Type: application/json');

    echo json_encode($output);
    exit;
}
