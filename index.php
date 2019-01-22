<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';

if (isset($_GET['authenticate'])) {
    header('Location: ' . $provider->getAuthorizationUrl(['basic:read']));
    exit;
}

if (isset($_GET['code'])) {
    if (!$provider->checkState($_GET['state'])) {
        redirect('/?reset', 'Invalid State');
    } else {
        try {
            $access_token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            if ($access_token->hasExpired()) {
                redirect('/?reset', 'Access Token invalid');
            }

            $user = $provider->authenticatedRequest(
                'GET',
                'https://api.lucacastelnuovo.nl/user/',
                $access_token->getToken()
            );

            $_SESSION['logged_in'] = true;
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];

            $existing_user = sql_select('users', 'id', "user_id='{$user['id']}'", true);
            if (empty($existing_user['id'])) {
                sql_insert('users', [
                    'user_id' => $user['id'],
                    'user_name' => $user['username'],
                    'profile_picture' => $user['profile_picture']
                ]);
                log_action('7', 'auth.first_login', $_SERVER["REMOTE_ADDR"], $user['id']);
            }

            log_action('7', 'auth.login', $_SERVER["REMOTE_ADDR"], $user['id']);
            redirect('/home', 'You are logged in');
        } catch (Exception $e) {
            redirect('/?reset', $e->getMessage());
        }
    }
}

if (isset($_GET['logout'])) {
    if ($_SESSION['logged_in']) {
        log_action('7', 'auth.logout', $_SERVER["REMOTE_ADDR"], $_SESSION['id']);
    }

    alert_set('You are logged out');
    reset_session();
}

if (isset($_GET['reset'])) {
    if ($_SESSION['logged_in']) {
        log_action('7', 'auth.reset', $_SERVER["REMOTE_ADDR"], $_SESSION['id']);
    }

    reset_session();
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    redirect('/home');
}

?>
<!DOCTYPE html>
<html>

<head>
    <!-- Config -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="manifest" href="/manifest.json" />
    <title>Login || InstaKilo</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.lucacastelnuovo.nl/general/css/materialize.css">
</head>

<body>
<div class="row">
    <div class="col s12 m8 offset-m2 l4 offset-l4">
        <div class="card">
            <div class="card-action blue accent-4 white-text">
                <h3>InstaKilo</h3>
            </div>
            <div class="card-content">
                <div class="row center">
                    <a class="waves-effect waves-light btn-large blue accent-4" href="?authenticate">
                        Login with LTC
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.lucacastelnuovo.nl/general/js/materialize.js"></script>
    <script src="/sw-register.js"></script>
    <?= alert_display() ?>
</body>

</html>
