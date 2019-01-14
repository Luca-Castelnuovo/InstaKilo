<?php

// CLEAN URL: /posts/actions/ACTION/CSRFtoken/POST_ID

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($_GET['type']) {
            case 'feed':
                $user_is_following = json_decode(sql_select('users', 'following', "user_id='{$_SESSION['id']}'", true)['following']);
                $user_is_following[] = "{$_SESSION['id']}";
                $user_is_following_sql = implode(',', array_map('intval', $user_is_following));
                $posts = sql_select('posts', 'id,img_url,caption,allow_comments,comments,likes,liked_by,created,user_id', "`user_id` IN ({$user_is_following_sql}) ORDER BY created DESC", false);

                if ($posts->num_rows != 0) {
                    $posts_item = [];
                    while ($post = $posts->fetch_assoc()) {
                        if ($post['allow_comments']) {
                            $comments_item = [];
                            foreach (json_decode($post['comments'], true) as $comment) {
                                $owner = sql_select('users', 'id,user_name,profile_picture', "user_id='{$comment['user_id']}'", true);

                                if ($comment['user_id'] == $_SESSION['id']) {
                                    $user_is_owner = true;
                                } else {
                                    $user_is_owner = false;
                                }

                                $comment_item = [
                                    'id' => $comment['id'],
                                    'username' => $owner['user_name'],
                                    'profile_picture' => $owner['profile_picture'],
                                    'body' => $comment['body'],
                                    'user_is_owner' => $user_is_owner
                                ];

                                array_push($comments_item, $comment_item);
                            }

                            $owner = sql_select('users', 'user_name', "user_id='{$post['user_id']}'", true);
                            $liked_by = json_decode($post['liked_by']);
                            $liked = in_array($_SESSION['id'], $liked_by);

                            $post_item = [
                                'id' => $post['id'],
                                'username' => $owner['user_name'],
                                'img_url' => $post['img_url'],
                                'caption' => $post['caption'],
                                'likes' => $post['likes'],
                                'liked' => $liked,
                                'comments_allowed' => true,
                                'comments' => $comments_item
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

                    response(true, '', ['posts' => $posts_item]);
                } else {
                    response(false, 'no_posts');
                }

                exit;

            case 'like':
                if (!csrf_val($_GET['CSRFtoken'], 'override')) {
                    response(false, 'csrf_error');
                }

                if (empty($_GET['post_id'])) {
                    response(false, 'post_id_empty');
                }

                $post_id = clean_data($_GET['post_id']);
                $post = sql_select('posts', 'id,likes,liked_by', "id='{$post_id}'", true);
                $post_liked_by = json_decode($post['liked_by']);

                if (empty($post['id'])) {
                    response(false, 'post_not_found');
                }

                if (in_array($_SESSION['id'], $post_liked_by)) {
                    response(false, 'post_already_liked');
                }

                $post_likes = $post['likes'] + 1;

                array_push($post_liked_by, $_SESSION['id']);

                sql_update('posts', ['likes' => $post_likes, 'liked_by' => json_encode($post_liked_by)], "id='{$post_id}'");

                response(true, 'Liked', ['likes' => $post_likes]);
                break;

            case 'undo_like':
                if (!csrf_val($_GET['CSRFtoken'], 'override')) {
                    response(false, 'csrf_error');
                }

                if (empty($_GET['post_id'])) {
                    response(false, 'post_id_empty');
                }

                $post_id = clean_data($_GET['post_id']);
                $post = sql_select('posts', 'id,likes,liked_by', "id='{$post_id}'", true);
                $post_liked_by = json_decode($post['liked_by']);

                if (empty($post['id'])) {
                    response(false, 'post_not_found');
                }

                if (!in_array($_SESSION['id'], $post_liked_by)) {
                    response(false, 'post_not_liked');
                }

                $post_likes = $post['likes'] - 1;

                if (($key = array_search($_SESSION['id'], $post_liked_by)) !== false) {
                    unset($post_liked_by[$key]);
                }

                sql_update('posts', ['likes' => $post_likes, 'liked_by' => json_encode($post_liked_by)], "id='{$post_id}'");

                response(true, 'Like removed', ['likes' => $post_likes]);
                break;

            default:
                response(false, 'unknown_type');
                break;
        }
        break;

    case 'POST':
        if (!csrf_val($_POST['CSRFtoken'], 'override')) {
            response(false, 'csrf_error');
        }

        $post_id = clean_data($_POST['post_id']);
        $comment_body = clean_data($_POST['comment']);

        $post = sql_select('posts', 'id,comments,allow_comments', "id='{$post_id}'", true);
        if (empty($post['id'])) {
            response(false, 'post_not_found');
        }

        if (!$post['allow_comments']) {
            response(false, 'comments_not_allowed');
        }

        $comments = json_decode($post['comments'], true);
        if (!is_array($comments)) {
            $comments = [];
        }

        $comment_id = gen(16);
        $comment = [
            'id' => $comment_id,
            'user_id' => $_SESSION['id'],
            'body' => $comment_body
        ];

        array_push($comments, $comment);

        sql_update('posts', ['comments' => json_encode($comments)], "id='{$post_id}'");

        // Get new comments
        $updated_post = sql_select('posts', 'comments', "id='{$post_id}'", true);
        $comments_item = [];
        foreach (json_decode($updated_post['comments'], true) as $comment) {
            $owner = sql_select('users', 'id,user_name,profile_picture', "user_id='{$comment['user_id']}'", true);

            if ($comment['user_id'] == $_SESSION['ide']) {
                $user_is_owner = true;
            } else {
                $user_is_owner = false;
            }

            $comment_item = [
                'id' => $comment['id'],
                'username' => $owner['user_name'],
                'profile_picture' => $owner['profile_picture'],
                'body' => $comment['body'],
                'user_is_owner' => $user_is_owner
            ];

            array_push($comments_item, $comment_item);
        }

        // New comment
        $sender = sql_select('users', 'user_name,profile_picture', "user_id='{$_SESSION['id']}'", true);
        $comment_js = [
            'id' => $comment_id,
            'username' => $sender['user_name'],
            'profile_picture' => $sender['profile_picture'],
            'body' => $comment_body,
            'user_is_owner' => true
        ];

        response(true, 'comment_sent', ['comments' => $comments_item, 'new_comment' => $comment_js]);
        break;

    default:
        response(false, 'incorrect_method');
        break;
}
