<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $messages = sql_select('messages', 'sender_id,body', "reciever_id='{$_SESSION['id']}' ORDER BY created DESC", false);

        if ($messages->num_rows != 0) {
            $messages_item = [];
            while ($message = $messages->fetch_assoc()) {
                $sender = sql_select('users', 'user_name,profile_picture', "user_id='{$messages['sender_id']}'", true);

                $message_item = [
                    'username' => $sender['user_name'],
                    'profile_picture' => $sender['profile_picture'],
                    'body' => $messages['body'],
                ];

                array_push($messages_item, $message_item);
            }

            response(true, '', ['messages' => $messages_item]);
        } else {
            response(false, 'no_messages');
        }
        break;

    case 'POST':
        csrf_val($_POST['CSRFtoken'], '/home');

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
