<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($_GET['type']) {
            case 'posts':
                $user_is_following = sql_select('users', 'following', "user_id='{$_SESSION['id']}'", true)['following'];
                $user_is_following_sql = implode(',', array_map('intval', $user_is_following));

                var_dump($user_is_following);
                var_dump($user_is_following_sql);
                exit;

                $posts = sql_select('posts', 'id,img_url,caption,allow_comments,comments,likes,liked_by,created', "`user_id` IN ('{$user_is_following_sql}')", false);

                if ($posts->num_rows != 0) {
                    while ($post = $posts->fetch_assoc()) {
                        if (in_array($_SESSION['id'], $post['liked_by'])) {
                            $liked = true;
                        } else {
                            $liked = false;
                        }

                        if ($post['allow_comments']) {
                            $response = [
                                'post_id' => $post['id'],
                                'img_url' => $post['img_url'],
                                'caption' => $post['caption'],
                                'likes' => $post['likes'],
                                'liked' => $liked,
                                /*
                                    foreach comment
                                    query username $comment_username

                                */
                                // 'comments' => [
                                //     [
                                //         'username' => $comment_username,
                                //         'comment' => $comment['comment'],
                                //     ]
                                // ]
                            ];
                        } else {
                            $response = [
                                'post_id' => $post['id'],
                                'img_url' => $post['img_url'],
                                'caption' => $post['caption'],
                                'likes' => $post['likes'],
                                'liked' => $liked,
                            ];
                        }
                    }

                    echo json_encode($response);
                } else {
                    echo json_encode(['error' => 'no_posts']);
                }

                exit;

            case 'like':
                // code...
                break;

            default:
                redirect('/home', 'Unknown Error');
                break;
        }
        break;

    case 'POST':
        //comment
        break;

    default:
        redirect('/home', 'Unknown Error');
        break;
}
