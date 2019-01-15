<?php

// CLEAN URL: /posts/edit/POST_ID

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

$post_id = clean_data($_REQUEST['post_id']);

$post = sql_select('posts', 'user_id,caption,allow_comments,img_url', "id='{$post_id}'", true);

if ($post['user_id'] === $_SESSION['id']) {
    redirect('/home', 'Access Denied');
}

if (isset($_GET['delete'])) {
    sql_delete('posts', "id='{$post_id}' AND user_id='{$_SESSION['id']}'");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['caption']) && strlen($_POST['caption']) > 400) {
        redirect('/posts/add', 'Caption too long');
    }

    $caption = clean_data($_POST['caption']);
    $allow_comments = clean_data($_POST['allow_comments']);

    if (empty($allow_comments)) {
        $allow_comments = 0;
    }

    sql_update(
        'posts',
        [
            'caption' => $caption,
            'allow_comments' => $allow_comments
        ],
        "id='{$post_id}' AND user_id='{$_SESSION['id']}'"
    );

    redirect('/home', 'Post Updated');
}

$post_allow_comments = $post['allow_comments'] ? 'checked' : null;

page_header('Update Post');
?>

<link rel="stylesheet" href="https://cdn.lucacastelnuovo.nl/instakilo.lucacastelnuovo.nl/css/filepond.css">

<div class="row">
    <form method="POST" class="col s12">
        <div class="row">
            <div class="col s12 center">
                <img src="<?= $post['img_url'] ?>" class="responsive-img">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <p>
                    <label>
                        <input type="checkbox"  class="filled-in" name="allow_comments" value="1" <?= $post_allow_comments ?>>
                        <span>Allow Comments</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="caption">Caption</label>
                <textarea id="caption" class="materialize-textarea counter" name="caption" required data-length="400"><?= $post['caption'] ?></textarea>
            </div>
        </div>
        <div class="row">
            <input type="hidden" name="CSRFtoken" value="<?= csrf_gen() ?>">
            <input type="hidden" name="post_id" value="<?= $post_id ?>">
            <button class="col s12 m8 btn-large waves-effect blue accent-4" type="submit">
                Update Post
            </button>
            <a href="/posts/edit?delete&post_id=<?= $post_id ?>" class="col s12 m8 btn-large waves-effect blue accent-4" onclick="return confirm('Are you sure?')">
                Delete Post
            </a>
        </div>
    </form>
</div>

<?= page_footer(); ?>
