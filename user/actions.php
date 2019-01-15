<?php

// CLEAN URL: /u/USERNAME/ACTION

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $username = clean_data($_GET['username']);

        if (empty($username)) {
            response(false, 'username_empty');
        }

        $switch ($_GET['type']) {
            case 'follow':

                response(true, 'Followed');
                break;

            case 'unfollow':

                response(true, 'Unfollowed');
                break;

            default:
                response(false, 'unknown_type');
                break;
        }
        break;

    default:
        response(false, 'incorrect_method');
        break;
}
