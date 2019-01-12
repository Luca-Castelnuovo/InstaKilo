<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($_GET['type']) {
            case 'posts':
                $user_is_following = json_decode(sql_select('users', 'following', "user_id='{$_SESSION['id']}'", true)['following']);
                $user_is_following_sql = implode(',', array_map('intval', $user_is_following));
                $posts = sql_select('posts', 'id,img_url,caption,allow_comments,comments,likes,liked_by,created', "`user_id` IN ('{$user_is_following_sql}') ORDER BY created DESC", false);

                if ($posts->num_rows != 0) {
                    $posts_item = [];
                    while ($post = $posts->fetch_assoc()) {
                        if (in_array($_SESSION['id'], $post['liked_by'])) {
                            $liked = true;
                        } else {
                            $liked = false;
                        }

                        if ($post['allow_comments']) {
                            $post_item = [
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
                            $post_item = [
                                'img_url' => $post['img_url'],
                                'caption' => $post['caption'],
                                'likes' => $post['likes'],
                                'liked' => $liked,
                            ];
                        }

                        array_push($posts_item, $post_item);
                    }

                    echo json_encode($posts_item);
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
