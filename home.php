<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

page_header('Home');
?>

<div class="row mb-0">
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large waves-effect waves-light blue accent-4" href="/posts/add">
            <i class="large material-icons">camera_alt</i>
        </a>
    </div>
</div>
<div class="row" data-sticky-container>
    <div class="col s12 l7">
        <div class="row mb-0">
            <div class="row" id="post_container"></div>
        </div>
        <div class="row center">
            <button id="loadBtn" class="btn-large waves-effect waves-light blue accent-4">Load more</button>
        </div>
    </div>
    <div class="col l1"></div>
    <div id="messages_box" class="col l4 hide-on-med-and-down" data-margin-top="79">
        <div class="row">
            <a class="col s12 btn-large waves-effect blue accent-4" href="/messages/">
                <h5>Messages</h5>
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

<?php
$CSRFtoken = csrf_gen();
$extra = <<<HTML
<script src="https://cdn.jsdelivr.net/gh/rgalus/sticky-js/dist/sticky.min.js"></script>
<script>
    var CSRFtoken = '{$CSRFtoken}'; var auto_init = false;

    document.addEventListener('DOMContentLoaded', function() {
        GETrequest(`https://instakilo.lucacastelnuovo.nl/posts/actions/feed`, function(response) {
            document.querySelector('#post_container').innerHTML = feed_render_posts(response);
            materialize_init();
            render_hashtags();
        });

        GETrequest(`https://instakilo.lucacastelnuovo.nl/messages/actions`, function(response) {
            document.querySelector('#messages_container').innerHTML = feed_render_messages(response);
        });

        var range = 10;
        document.querySelector('#loadBtn').addEventListener('click', function() {
            GETrequest(`https://instakilo.lucacastelnuovo.nl/posts/actions/feed&range=${range}`, function(response) {
                range += 10;
                var new_posts = feed_render_posts(response, true);
                 if (new_posts !== false) {
                    post_container.innerHTML += new_posts;
                    materialize_init();
                    render_hashtags();
                } else {
                    post_container.innerHTML += `
                        <div class="col s12">
                            <div class="card-panel">
                                <p>End of posts</p>
                            </div>
                        </div>
                    `;

                    document.querySelector('#loadBtn').classList.add('hidden');
                }
            });
        });
    });
</script>
HTML;

page_footer($extra);

?>
