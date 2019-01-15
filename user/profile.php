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
    <div class="col s12 center">
        <pre>
            <?= var_dump($user) ?>
        </pre>
    </div>
</div>

<?= page_footer(); ?>
