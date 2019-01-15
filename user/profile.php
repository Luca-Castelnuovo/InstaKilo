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
                            <h2 class="mt-0"><?= $user_name ?></h2>
                            <a onclick="user_follow('<?= $user_name ?>')" class="waves-effect waves-light btn tooltipped blue accent-4 col s12" data-position="bottom" data-tooltip="Unfollow">Follow</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <a onclick="user_followers('<?= $user_name ?>')" class="accent-4 blue btn-small pointer waves-effect waves-light col s12"><span class="bold"><?= $followers_count ?></span> followers</a>
                        </div>
                        <div class="col s6">
                            <a onclick="user_following('<?= $user_name ?>')" class="accent-4 blue btn-small pointer waves-effect waves-light col s12"><span class="bold"><?= $following_count ?></span> following</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <p><?= $user['bio'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablet and up -->
    <div class="hide-on-small-only">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s5">
                            <img src="<?= $user['profile_picture'] ?>" onerror="this.src='https://github.com/identicons/<?= $user_name ?>.png'" class="circle" width="200">
                        </div>
                        <div class="col s7">
                            <div class="row">
                                <div class="col s12">
                                    <h2><?= $user_name ?></h2>
                                    <a onclick="user_follow('<?= $user_name ?>')" class="waves-effect waves-light btn tooltipped blue accent-4 col s12" data-position="left" data-tooltip="Unfollow">Follow</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <a onclick="user_followers('<?= $user_name ?>')" class="accent-4 blue btn-small pointer waves-effect waves-light col s12"><span class="bold"><?= $followers_count ?></span> followers</a>
                                </div>
                                <div class="col s6">
                                    <a onclick="user_following('<?= $user_name ?>')" class="accent-4 blue btn-small pointer waves-effect waves-light col s12"><span class="bold"><?= $following_count ?></span> following</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <p><?= $user['bio'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="following_modal">
    <div class="modal-content">
        <div class="col s6">
            <h4>Following</h4>
        </div>
        <div class="col s6">
            <a class="btn-floating btn waves-effect waves-light blue accent-4 right modal-close">
                <i class="material-icons">close</i>
            </a>
        </div>
        <div class="row">
            <ul class="collection">
                <div id="following_container"></div>
            </ul>
        </div>
    </div>
</div>

<div class="modal" id="followers_modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s6">
                <h4>Followers</h4>
            </div>
            <div class="col s6">
                <a class="btn-floating btn waves-effect waves-light blue accent-4 right modal-close">
                    <i class="material-icons">close</i>
                </a>
            </div>
        </div>
        <div class="row">
            <ul class="collection">
                <div id="followers_container"></div>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div id="post_container"></div>
</div>

<?php

$CSRFtoken = csrf_gen();
$extra = <<<HTML
<script>
    var CSRFtoken = '{$CSRFtoken}';
    var auto_init = false;
    var user_name = '<?= $user_name ?>';

    document.addEventListener('DOMContentLoaded', function() {
        GETrequest(`https://instakilo.lucacastelnuovo.nl/u/${user_name}/feed`, function(response) {
            document.querySelector('#post_container').innerHTML = feed_render_posts(response);
            materialize_init();
        });
    });
</script>
HTML;

?>
<?= page_footer($extra); ?>
