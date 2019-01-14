<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

page_header('Home');
?>
        <div class="row">
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large waves-effect waves-light blue accent-4" href="/posts/add">
                    <i class="large material-icons">camera_alt</i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col s12 l7">
                <div class="row">
                    <div class="row" id="post_container"></div>
                </div>
            </div>
            <div class="col l1"></div>
            <div class="col l4 hide-on-med-and-down">
                <div class="row">
                    <a class="col s12 btn-large waves-effect blue accent-4" href="#!">
                        <h5>Berichten</h5>
                    </a>
                </div>
                <div class="row" id="post_container"></div>
                <div class="row">
                    <ul class="collection">
                        <div class="row" id="messages_container"></div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$CSRFtoken = csrf_gen();
$extra = <<<HTML
<script>
    var CSRFtoken = '{$CSRFtoken}'; var auto_init = false;

    document.addEventListener('DOMContentLoaded', function() {
        request('GET', `https://instakilo.lucacastelnuovo.nl/posts/actions/feed`, function(response) {
            CSRFtoken = response.CSRFtoken;

            document.querySelector('#post_container').innerHTML = feed_render_posts(response);
            materialize_init();
        });

        request('GET', `https://instakilo.lucacastelnuovo.nl/messages/actions`, function(response) {
            CSRFtoken = response.CSRFtoken;

            document.querySelector('#messages_container').innerHTML = feed_render_messages(response);
        });
    });
</script>
HTML;

page_footer($extra);

?>
