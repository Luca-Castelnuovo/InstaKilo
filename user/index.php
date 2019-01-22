<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

page_header('Users');
?>

<div class="row">
    <div class="col s12">
        <?php

            $users = sql_query('users', 'user_name,profile_picture', 'true', false);

            while ($user = $users->fetch_assoc()) {
                echo <<<END
                <div class="col s12 m6 l4 xl3">
                    <div class="card medium hoverable">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="responsive-img" src="{$user['profile_picture']}" onerror="this.src='https://cdn.lucacastelnuovo.nl/general/images/profile_picture.png'">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4 center">
                                {$user['user_name']}
                            </span>
                        </div>
                    </div>
                </div>
END;
            }

        ?>
    </div>
</div>

<?= page_footer(); ?>
