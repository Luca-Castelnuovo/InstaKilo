<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_val($_POST['CSRFtoken'], '/home');

    if (empty($_POST['post_img']) || empty($_POST['post_img'])) {
        redirect('/posts/add', 'Please fill in everything');
    }

    if (strlen($_POST['caption']) > 400) {
        redirect('/posts/add', 'Caption too long');
    }

    $img_url = clean_data($_POST['post_img']);
    $caption = clean_data($_POST['caption']);
    $allow_comments = clean_data($_POST['allow_comments']);

    if (empty($allow_comments)) {
        $allow_comments = 0;
    }

    sql_insert('posts', [
        'user_id' => $_SESSION['id'],
        'img_url' => $img_url,
        'caption' => $caption,
        'allow_comments' => $allow_comments,
        'created' => date("Y-m-d H:i:s")
    ]);

    redirect('/home', 'Posted');
}

page_header('Edit Profile');
?>

<link rel="stylesheet" href="https://cdn.lucacastelnuovo.nl/instakilo.lucacastelnuovo.nl/css/filepond.css">

<div class="row">
    <form method="POST" class="col s12">
        Change Password
        Change bio
        Change Profile Picture
        <div class="row">
            <input type="hidden" name="CSRFtoken" value="<?= csrf_gen() ?>">
            <button class="col s12 btn-large waves-effect blue accent-4" type="submit">
                Update Profile
            </button>
        </div>
    </form>
</div>

<?= page_footer(); ?>
