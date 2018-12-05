<?php

# Copyright Luca Castelnuovo

$GLOBALS['server_token'] = '(Request Server Token ltcastelnuovo@gmail.com)';


function auth_request($page, $data)
{
    $url  = 'https://auth.lucacastelnuovo.nl/' . $page;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, true);

    return $result;
}

function auth_register()
{
    $register_request = auth_request('register.php', ["type" => "gen", "callback_url"  => "https://hyp3ri0n.ml/auth/register.php?register_complete", "server_token" => "{$GLOBALS['server_token']}"]);
    if (!$register_request['status']) {
        return false;
    } else {
        return $register_request;
    }
}


function auth_login($username, $password)
{
    return auth_request('login.php', ["username" => "{$username}", "password" => "{$password}", "server_token" => "{$GLOBALS['server_token']}"]);
}


function auth_check($client_token)
{
    return auth_request('check.php', ["token" => "{$client_token}", "server_token" => "{$GLOBALS['server_token']}"]);
}


function auth_logout($client_token)
{
    return auth_request('logout.php', ["token" => "{$client_token}", "server_token" => "{$GLOBALS['server_token']}"]);
}
