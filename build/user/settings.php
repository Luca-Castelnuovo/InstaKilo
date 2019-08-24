<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

// TODO: build page
redirect('/home', 'Work In Progress');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_val($_POST['CSRFtoken'], '/home');

    //update user

    log_action('7', 'user.updated', $_SERVER["REMOTE_ADDR"], $_SESSION['id']);
    redirect('/home', 'Posted');
}

page_header('Edit Profile');
?>

<!-- TODO: add cdn link -->
<link rel="stylesheet" href="https://instakilo.lucacastelnuovo.nl/css/filepond.css">

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
