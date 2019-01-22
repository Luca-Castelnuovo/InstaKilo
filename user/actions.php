<?php

// CLEAN URL: /u/USERNAME/ACTION

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $username = clean_data($_GET['username']);
        $user = sql_select('users', '*', "user_name='{$username}'", true);

        if (empty($user['id'])) {
            response(false, 'user_not_found');
        }

        if (empty($username)) {
            response(false, 'username_empty');
        }

        switch ($_GET['type']) {
            case 'follow':
                if (!csrf_val($_GET['CSRFtoken'], 'override')) {
                    response(false, 'csrf_error');
                }

                $logged_in_user = sql_select('users', 'following', "user_id='{$_SESSION['id']}'", true);
                $logged_in_user_following = json_decode($logged_in_user['following']);

                if (in_array($user['user_id'], $logged_in_user_following)) {
                    response(false, 'user_already_following');
                }

                if ($user['user_id'] == $_SESSION['id']) {
                    response(false, 'cant_follow_yourself');
                }

                array_push($logged_in_user_following, intval($user['user_id']));

                sort($logged_in_user_following);

                sql_update(
                    'users',
                    [
                        'following' => json_encode($logged_in_user_following),
                    ],
                    "user_id='{$_SESSION['id']}'"
                );

                response(true, 'followed');
                break;

            case 'undo_follow':
                if (!csrf_val($_GET['CSRFtoken'], 'override')) {
                    response(false, 'csrf_error');
                }

                $logged_in_user = sql_select('users', 'following', "user_id='{$_SESSION['id']}'", true);
                $logged_in_user_following = json_decode($logged_in_user['following']);

                if (!in_array($user['user_id'], $logged_in_user_following)) {
                    response(false, 'user_not_following');
                }

                if (($key = array_search($user['user_id'], $logged_in_user_following)) !== false) {
                    unset($logged_in_user_following[$key]);
                }

                sort($logged_in_user_following);

                sql_update(
                    'users',
                    [
                        'following' => json_encode($logged_in_user_following),
                    ],
                    "user_id='{$_SESSION['id']}'"
                );

                response(true, 'undo_followed');
                break;

            case 'followers':
                // //Get followers
                // $user = sql_select('users', 'following', "user_name='{$user_name}'", true);
                // $followers = json_decode($user['following']);
                // // End Get Followers
                //
                //
                // $user_visiting = sql_select('users', 'following', "user_id='{$_SESSION['id']}'", true);
                // $user_followers = json_decode($user_visiting['following']);
                //
                // $all_followers = [];
                //
                // foreach ($followers as $follower) {
                //     $user_follower = sql_select('users', 'user_name,profile_picture', "user_id='{$follower}'", true);
                //
                //     if (in_array($user_followers, $follower)) {
                //         $is_following = true;
                //     } else {
                //         $is_following = false;
                //     }
                //
                //
                //     $follower_user = [
                //         'username' => $user_follower['user_name'],
                //         'profile_picture' => $user_follower['profile_picture'],
                //         'is_following' => $is_following
                //     ];
                //
                //     array_push($all_followers, $follower_user);
                // }
                //
                // response(true, '', ['followers' => $all_followers]);
                break;

            case 'following':
                $user_is_following = json_decode($user['following']);

                $visitor = sql_select('users', 'following', "user_id='{$_SESSION['id']}'", true);
                $visitor_followings = json_decode($visitor['following']);

                $user_is_following_output = [];

                foreach ($user_is_following as $following) {
                    if (in_array($following, $visitor_followings)) {
                        $is_following = true;
                    } else {
                        $is_following = false;
                    }

                    $user_following = sql_select('users', 'user_name,profile_picture', "user_id='{$following}'", true);

                    $following_user = [
                        'username' => $user_following['user_name'],
                        'profile_picture' => $user_following['profile_picture'],
                        'is_following' => $is_following
                    ];

                    array_push($user_is_following_output, $following_user);
                }

                response(true, '', ['following' => $user_is_following_output, 'following_number' => count($user_is_following)]);
                break;

            case 'feed':
                $post_owner = sql_select('users', 'user_id', "user_name='{$username}'", true);
                $posts = sql_select('posts', 'id,img_url,caption,likes,liked_by,user_id', "user_id='{$post_owner['user_id']}' ORDER BY created DESC", false);

                if ($posts->num_rows != 0) {
                    $posts_item = [];

                    while ($post = $posts->fetch_assoc()) {
                        $owner = sql_select('users', 'user_name', "user_id='{$post['user_id']}'", true);
                        $liked_by = json_decode($post['liked_by']);
                        $liked = in_array($_SESSION['id'], $liked_by);

                        if ($post['user_id'] == $_SESSION['id']) {
                            $user_is_owner_post = true;
                        } else {
                            $user_is_owner_post = false;
                        }

                        $post_item = [
                            'id' => $post['id'],
                            'user_is_owner' => $user_is_owner_post,
                            'username' => $owner['user_name'],
                            'img_url' => $post['img_url'],
                            'caption' => $post['caption'],
                            'likes' => $post['likes'],
                            'liked' => $liked,
                            'comments_allowed' => false,
                            'comments' => null
                        ];

                        array_push($posts_item, $post_item);
                    }

                    response(true, '', ['posts' => $posts_item]);
                    break;
                }
    exit;

    default:
        response(false, 'incorrect_method');
        exit;
    }
}
