<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        csrf_val($_GET['CSRFtoken'], '/home');
        switch ($_GET['type']) {
            case 'posts':
                $user_is_following = json_decode(sql_select('users', 'following', "user_id='{$_SESSION['id']}'", true)['following']);
                $user_is_following_sql = implode(',', array_map('intval', $user_is_following));
                $posts = sql_select('posts', 'id,img_url,caption,allow_comments,comments,likes,liked_by,created', "`user_id` IN ('{$user_is_following_sql}') ORDER BY created DESC", false);

                if ($posts->num_rows != 0) {
                    $posts_item = [];
                    while ($post = $posts->fetch_assoc()) {
                        if (in_array($_SESSION['id'], json_decode($post['liked_by']))) {
                            $liked = true;
                        } else {
                            $liked = false;
                        }

                        if ($post['allow_comments']) {
                            $post_item = [
                                'post_id' => $post['id'],
                                'img_url' => $post['img_url'],
                                'caption' => $post['caption'],
                                'likes' => $post['likes'],
                                'liked' => $liked,
                                'comments' => 'WORK IN PROGRESS',
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
                                'post_id' => $post['id'],
                                'img_url' => $post['img_url'],
                                'caption' => $post['caption'],
                                'likes' => $post['likes'],
                                'liked' => $liked,
                                'comments' => null,
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
                if (empty($_GET['post_id'])) {
                    redirect('/home', 'Unknown Error');
                }

                $post_id = clean_data($_GET['post_id']);
                $post = sql_select('posts', 'likes,liked_by', "id='{$post_id}'", true);
                $post_likes = $post['likes'] + 1;
                $post_liked_by = json_decode($post['liked_by']);

                array_push($post_liked_by, $_SESSION['id']);

                sql_update('posts', ['likes' => $post_likes, 'liked_by' => $post_liked_by], "id='{$post_id}'");
                break;

            case 'unlike':
                if (empty($_GET['post_id'])) {
                    redirect('/home', 'Unknown Error');
                }

                $post_id = clean_data($_GET['post_id']);
                $post = sql_select('posts', 'likes,liked_by', "id='{$post_id}'", true);
                $post_likes = $post['likes'] - 1;
                $post_liked_by = json_decode($post['liked_by']);

                if (($key = array_search($_SESSION['id'], $post_liked_by)) !== false) {
                    unset($post_liked_by[$key]);
                }

                sql_update('posts', ['likes' => $post_likes, 'liked_by' => $post_liked_by], "id='{$post_id}'");
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
