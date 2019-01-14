<?php

// CLEAN URL: /posts/actions/ACTION/CSRFtoken/POST_ID

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($_GET['type']) {
            case 'feed':
                $user_is_following = json_decode(sql_select('users', 'following', "user_id='{$_SESSION['id']}'", true)['following']);
                $user_is_following_sql = implode(',', array_map('intval', $user_is_following));
                $posts = sql_select('posts', 'id,img_url,caption,allow_comments,comments,likes,liked_by,created,user_id', "`user_id` IN ('{$user_is_following_sql}') ORDER BY created DESC", false);

                if ($posts->num_rows != 0) {
                    $posts_item = [];
                    while ($post = $posts->fetch_assoc()) {
                        $owner = sql_select('users', 'user_name', "user_id='{$post['user_id']}'", true);
                        $liked_by = json_decode($post['liked_by']);
                        $liked = in_array($_SESSION['id'], $liked_by);

                        if ($post['allow_comments']) {
                            $post_item = [
                                'id' => $post['id'],
                                'username' => $owner['user_name'],
                                'img_url' => $post['img_url'],
                                'caption' => $post['caption'],
                                'likes' => $post['likes'],
                                'liked' => $liked,
                                'comments_allowed' => true,
                                'comments' => json_decode($post['comments'], true)
                            ];
                        } else {
                            $post_item = [
                                'id' => $post['id'],
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

                    response(true, '', ['posts' => $posts_item, 'CSRFtoken' => csrf_gen()]);
                } else {
                    response(false, 'no_posts', ['CSRFtoken' => csrf_gen()]);
                }

                exit;

            case 'like':
                if (!csrf_val($_GET['CSRFtoken'], 'override')) {
                    response(false, 'csrf_error', ['CSRFtoken' => csrf_gen()]);
                }

                if (empty($_GET['post_id'])) {
                    response(false, 'post_id_empty', ['CSRFtoken' => csrf_gen()]);
                }

                $post_id = clean_data($_GET['post_id']);
                $post = sql_select('posts', 'likes,liked_by', "id='{$post_id}'", true);
                $post_liked_by = json_decode($post['liked_by']);

                if (empty($post['likes'])) {
                    response(false, 'post_not_found', ['CSRFtoken' => csrf_gen()]);
                }

                if (in_array($_SESSION['id'], $post_liked_by)) {
                    response(false, 'post_already_liked', ['CSRFtoken' => csrf_gen()]);
                }

                $post_likes = $post['likes'] + 1;

                array_push($post_liked_by, $_SESSION['id']);

                sql_update('posts', ['likes' => $post_likes, 'liked_by' => json_encode($post_liked_by)], "id='{$post_id}'");

                response(true, 'Liked', ['CSRFtoken' => csrf_gen(), 'likes' => $post_likes]);
                break;

            case 'undo_like':
                if (!csrf_val($_GET['CSRFtoken'], 'override')) {
                    response(false, 'csrf_error', ['CSRFtoken' => csrf_gen()]);
                }

                if (empty($_GET['post_id'])) {
                    response(false, 'post_id_empty', ['CSRFtoken' => csrf_gen()]);
                }

                $post_id = clean_data($_GET['post_id']);
                $post = sql_select('posts', 'likes,liked_by', "id='{$post_id}'", true);
                $post_liked_by = json_decode($post['liked_by']);

                if (empty($post['likes'])) {
                    response(false, 'post_not_found', ['CSRFtoken' => csrf_gen()]);
                }

                if (!in_array($_SESSION['id'], $post_liked_by)) {
                    response(false, 'post_not_liked', ['CSRFtoken' => csrf_gen()]);
                }

                $post_likes = $post['likes'] - 1;

                if (($key = array_search($_SESSION['id'], $post_liked_by)) !== false) {
                    unset($post_liked_by[$key]);
                }

                sql_update('posts', ['likes' => $post_likes, 'liked_by' => json_encode($post_liked_by)], "id='{$post_id}'");

                response(true, 'Like removed', ['CSRFtoken' => csrf_gen(), 'likes' => $post_likes]);
                break;

            default:
                response(false, 'unknown_type', ['CSRFtoken' => csrf_gen()]);
                break;
        }
        break;

    case 'POST':
        if (!csrf_val($_POST['CSRFtoken'], 'override')) {
            response(false, 'csrf_error', ['CSRFtoken' => csrf_gen()]);
        }

        $post_id = clean_data($_POST['post_id']);
        $comment = clean_data($_POST['comment']);

        $post = sql_select('posts', 'comments', "id='{$post_id}'", true);
        if (empty($post['comments'])) {
            response(false, 'post_not_found', ['CSRFtoken' => csrf_gen()]);
        }

        $sender = sql_query('users', 'user_name,profile_picture', "user_id='{$_SESSION['id']}'", true);

        $comments =  $post['comments'];
        $comment = [
            'username' => $sender['user_name'],
            'profile_picture' => $sender['profile_picture'],
            'body' => $comment
        ];
        array_push($comments, $comment);

        sql_update('posts', ['comments' => json_encode($comments)], "id='{$post_id}'");

        response(true, 'comment_sent', ['CSRFtoken' => csrf_gen(), 'comments' => $comments, 'new_comment' => $comment]);
        break;

    default:
        response(false, 'incorrect_method', ['CSRFtoken' => csrf_gen()]);
        break;
}
