<?php

// Send POST request
function request($url, $data, $redirect_on_error = 'index.php')
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, true);

    // Set error and redirect if status false (unless override)
    if (!$result['status'] && $redirect_on_error != 'override') {
        redirect($redirect_on_error, $result['error']);
    }

    return $result;
}


//Send mails
function send_mail($to, $subject, $body)
{
    // Get token
    $login = request('https://auth.lucacastelnuovo.nl/login.php', ["username" => "{$GLOBALS['config']->mail->username}", "password" => "{$GLOBALS['config']->mail->password}", "server_token" => "{$GLOBALS['config']->server_token}"], 'home.php');

    //Use token
    $api = request('https://api.lucacastelnuovo.nl/mail/', ["token" => "{$login['token']}", "to" => "{$to}", "subject" => "{$subject}", "from_name" => "Hyp3ri0n", "body" => "{$body}"], 'home.php');
}
