<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

// TODO: build page
redirect('/home', 'Work In Progress');

page_header('Messages');

?>

<div class="row">
    <div class="col s12">
        <h4>Messages</h4>
        <div id="messages_container"></div>
    </div>
</div>

<?php
$CSRFtoken = csrf_gen();
$extra = <<<HTML
<script>
    var CSRFtoken = '{$CSRFtoken}';

    document.addEventListener('DOMContentLoaded', function() {
        // Get messages
        // GETrequest(`https://instakilo.lucacastelnuovo.nl/posts/actions/feed`, function(response) {
        //     document.querySelector('#post_container').innerHTML = feed_render_posts(response);
        //     render_hashtags();
        // });
    });
</script>
HTML;

page_footer($extra);

?>
