<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

page_header('Users');
?>

<div class="row">
    <div class="col s12">
        <?php

            $users = sql_select('users', 'user_name,profile_picture', 'true ORDER BY user_name DESC', false);

            while ($user = $users->fetch_assoc()) {
                echo <<<END
                <a href="/u/{$user['user_name']}">
                    <div class="col s12 m6 l4 xl3">
                        <div class="card small">
                            <div class="card-image waves-effect waves-block waves-light">
                                <img src="{$user['profile_picture']}" onerror="this.src='https://cdn.lucacastelnuovo.nl/general/images/profile_picture.png'">
                            </div>
                            <div class="card-content">
                                <span class="card-title center">
                                    {$user['user_name']}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
END;
            }

        ?>
    </div>
</div>

<?= page_footer(); ?>
