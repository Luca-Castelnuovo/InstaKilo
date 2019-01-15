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

                response(true, '', ['followers' => $followers]);
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

                response(true, '', ['following' => $following]);
                break;

            case 'feed':
                $post_owner = sql_select('users', 'user_id', "user_name='{$username}'", true);
                $posts = sql_select('posts', 'id,img_url,caption,allow_comments,comments,likes,liked_by,created,user_id', "user_id='{$post_owner['user_id']}' ORDER BY created DESC", false);

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

                        if ($post['allow_comments']) {
                            $comments_item = [];
                            foreach (json_decode($post['comments'], true) as $comment) {
                                $owner_comments = sql_select('users', 'id,user_name,profile_picture', "user_id='{$comment['user_id']}'", true);

                                if ($comment['user_id'] == $_SESSION['id']) {
                                    $user_is_owner_comment = true;
                                } else {
                                    $user_is_owner_comment = false;
                                }

                                $comment_item = [
                                    'id' => $comment['id'],
                                    'username' => $owner_comments['user_name'],
                                    'profile_picture' => $owner_comments['profile_picture'],
                                    'body' => $comment['body'],
                                    'user_is_owner' => $user_is_owner_comment
                                ];

                                array_push($comments_item, $comment_item);
                            }

                            $post_item = [
                                'id' => $post['id'],
                                'user_is_owner' => $user_is_owner_post,
                                'username' => $owner['user_name'],
                                'img_url' => $post['img_url'],
                                'caption' => $post['caption'],
                                'likes' => $post['likes'],
                                'liked' => $liked,
                                'comments_allowed' => true,
                                'comments' => $comments_item,
                            ];
                        } else {
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
                        }

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
