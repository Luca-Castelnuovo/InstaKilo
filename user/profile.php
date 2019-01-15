<?php

// CLEAN URL: /u/USERNAME -> /user/profile.php?user_name=$1

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

$user_name = clean_data($_REQUEST['user_name']);

$user = sql_select('users', 'user_id,profile_picture,bio,following,is_private', "user_name='{$user_name}'", true);

if (empty($user['user_id'])) {
    redirect('/home', 'User doesn\'t exist');
}

page_header($user_name);

?>

<div class="row">
    <div class="col m4 hide-on-small-only">
        <img src="<?= $user['profile_picture'] ?>" onerror="this.src='https://github.com/identicons/<?= $user_name ?>.png'" class="circle">
    </div>
    <div class="col s12 show-on-small center">
        <img src="<?= $user['profile_picture'] ?>" onerror="this.src='https://github.com/identicons/<?= $user_name ?>.png'" class="circle">
    </div>
    <div class="col s12 m6">
        <h2><?= $user_name ?></h2>
        <p><?= $user['bio'] ?></p>
    </div>
    <div class="col s12 m2">
        <a href="#!" class="waves-effect waves-light btn blue accent-4">Follow</a>
    </div>
</div>

<?= page_footer(); ?>
