<?php

// CLEAN URL: /u/USERNAME -> /user/profile.php?user_name=$1

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

$user_name = clean_data($_REQUEST['user_name']);

$user = sql_select('users', 'user_id,profile_picture,bio,following,is_private', "user_name='{$user_name}'", true);

if (empty($user['user_id'])) {
    redirect('/home', 'User doesn\'t exist');
}

$followers_count = 100;
$following_count = 100;

page_header($user_name);

?>

<div class="row">
    <!-- Phone -->
    <div class="hide-on-med-and-up center">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s12">
                            <img src="<?= $user['profile_picture'] ?>" onerror="this.src='https://github.com/identicons/<?= $user_name ?>.png'" class="circle" width="200">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <h2><?= $user_name ?></h2>
                            <p><?= $user['bio'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <a href="#!" class="col s12 waves-effect waves-light btn tooltipped blue accent-4" data-position="bottom" data-tooltip="Unfollow">Follow</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablet and up -->
    <div class="hide-on-small-only">
        <div class="row">
            <div class="col m12">
                <div class="card-panel">
                    <div class="row">
                        <div class="col m5">
                            <img src="<?= $user['profile_picture'] ?>" onerror="this.src='https://github.com/identicons/<?= $user_name ?>.png'" class="circle" width="200">
                        </div>
                        <div class="col m7">
                            <div class="row">
                                <div class="col m9">
                                    <h2><?= $user_name ?></h2>
                                </div>
                                <div class="col m3">
                                    <a href="#!" class="waves-effect waves-light btn tooltipped blue accent-4" data-position="bottom" data-tooltip="Unfollow">Follow</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col m6">
                                    <a onclick="user_followers()" class="black-text"><span><?= $followers_count ?></span> followers</a>

                                    <div class="modal" id="followers_modal">
                                        <div class="modal-content">
                                            <div class="row">
                                                <h4>Followers</h4>
                                                <button type="submit" class="btn-floating btn waves-effect waves-light blue accent-4 right">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <ul class="collection">
                                                    <div id="followers_container"></div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col m6">
                                    <a onclick="user_following()" class="black-text"><span><?= $following_count ?></span> following</a>

                                    <div class="modal" id="following_modal">
                                        <div class="modal-content">
                                            <div class="row">
                                                <h4>Following</h4>
                                                <button type="submit" class="btn-floating btn waves-effect waves-light blue accent-4 right">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <ul class="collection">
                                                    <div id="following_container"></div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col m12">
                            <p><?= $user['bio'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- List posts -->
</div>

<?= page_footer(); ?>
