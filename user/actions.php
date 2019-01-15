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

        switch ($_GET['type']) {
            case 'follow':

                response(true, 'Followed');
                break;

            case 'unfollow':

                response(true, 'Unfollowed');
                break;

            case 'followers':

                $followers = [
                    [
                        'username' => 'MathijsH',
                        'profile_picture' => 'https://i.imgur.com/R1WaY0a.jpg',
                        'is_following' => true
                    ],
                    [
                        'username' => 'MarvinAlien',
                        'profile_picture' => 'https://st.depositphotos.com/1020915/4615/i/950/depositphotos_46154511-stock-photo-man-in-profile-with-green.jpg',
                        'is_following' => false
                    ]
                ];

                response(true, 'followers', ['followers' => $followers]);
                break;

            case 'following':

                $following = [
                    [
                        'username' => 'MathijsH',
                        'profile_picture' => 'https://i.imgur.com/R1WaY0a.jpg',
                    ],
                    [
                        'username' => 'MarvinAlien',
                        'profile_picture' => 'https://st.depositphotos.com/1020915/4615/i/950/depositphotos_46154511-stock-photo-man-in-profile-with-green.jpg',
                    ]
                ];

                response(true, 'following', ['following' => $following]);
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
