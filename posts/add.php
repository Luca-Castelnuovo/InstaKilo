<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //save post

    //sql_insert

    redirect('/home', 'Posted');
}

page_header('Create Post');
?>

<link rel="stylesheet" href="https://cdn.lucacastelnuovo.nl/instakilo.lucacastelnuovo.nl/css/filepond.css">

<div class="row">
    <form method="POST" class="col s12">
        <h4>New Post</h4>
        <div class="row">
            <div class="input-field col s12 m8">
                <input type="file" name="post_img">
            </div>
            <div class="input-field col s12 m4">
                <div class="switch">
                    Comments
                    <label>
                        Off
                        <input type="checkbox" name="allow_comments" value="1" checked>
                        <span class="lever"></span>
                        On
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="caption">Caption</label>
                <textarea id="caption" class="materialize-textarea counter" name="caption" data-length="200"></textarea>
            </div>
        </div>
    </form>
</div>

<?php

$extra = <<<HTML
    <script src="https://cdn.lucacastelnuovo.nl/instakilo.lucacastelnuovo.nl/js/filepond/lib.js"></script>
    <script src="https://cdn.lucacastelnuovo.nl/instakilo.lucacastelnuovo.nl/js/filepond/init.js"></script>
HTML;

page_footer($extra);

?>
