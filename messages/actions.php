<?php

// CLEAN URL: /posts/actions/CSRFtoken

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
// loggedin();
$_SESSION['id'] = '12';

// csrf_val($_REQUEST['CSRFtoken'], '/home');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        response(true, 'WIP');

        $messages = sql_select('messages', 'id,bidy', "to='{$_SESSION['id']}' ORDER BY created DESC", false);

        if ($messages->num_rows != 0) {
            $messages_item = [];
            while ($message = $messages->fetch_assoc()) {
                $sender = sql_select('users', 'user_name', "user_id='{$messages['sender_id']}'", true);

                $message_item = [
                    'id' => $post['id'],
                    'username' => $owner['user_name'],
                    'img_url' => $post['img_url'],
                    'caption' => $post['caption'],
                    'likes' => $post['likes'],
                    'liked' => $liked,
                    'comments_allowed' => true,
                    'comments' => json_decode($post['comments'], true)
                ];

                array_push($messages_item, $message_item);
            }

            response(true, '', ['messages' => $messages_item]);
        } else {
            response(false, 'no_messages');
        }
        break;

    case 'POST':
        if (empty($_POST['user_id'])) {
            response(false, 'user_id_empty');
        }

        $user_id = clean_data($_POST['user_id']);

        //sql_insert message

        response(true, 'message_sent');
        break;

    default:
        response(false, 'incorrect_method');
        break;
}
