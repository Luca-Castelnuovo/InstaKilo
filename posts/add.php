<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_val($_POST['CSRFtoken'], '/home');

    if (empty($_POST['post_img']) || empty($_POST['post_img'])) {
        redirect('/posts/add', 'Please fill in everything');
    }

    if (strlen($_POST['caption']) > 400) {
        redirect('/posts/add', 'Caption too long');
    }

    $img_url = clean_data($_POST['post_img']);
    $caption = clean_data($_POST['caption']);
    $allow_comments = clean_data($_POST['allow_comments']);

    if (empty($allow_comments)) {
        $allow_comments = 0;
    }

    sql_insert('posts', [
        'user_id' => $_SESSION['id'],
        'img_url' => $img_url,
        'caption' => $caption,
        'allow_comments' => $allow_comments,
        'created' => date("Y-m-d H:i:s")
    ]);

    redirect('/home', 'Posted');
}

page_header('Create Post');
?>

<link rel="stylesheet" href="https://cdn.lucacastelnuovo.nl/instakilo.lucacastelnuovo.nl/css/filepond.css">

<div class="row">
    <form method="POST" class="col s12">
        <div class="row">
            <div class="input-field col s12 m8">
                <input type="file" name="post_img" required>
            </div>
            <div class="input-field col s12 m4">
                <p>
                    <label>
                        <input type="checkbox"  class="filled-in" name="allow_comments" value="1" checked>
                        <span>Allow Comments</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="caption">Caption</label>
                <textarea id="caption" class="materialize-textarea counter validate" name="caption" required data-length="400"></textarea>
            </div>
        </div>
        <div class="row">
            <input type="hidden" name="CSRFtoken" value="<?= csrf_gen() ?>">
            <button class="col s12 btn-large waves-effect blue accent-4" type="submit">
                Submit Post
            </button>
        </div>
    </form>
</div>

<?php

$extra = <<<HTML
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.6.15/browser-polyfill.min.js"></script>
    <script src="https://unpkg.com/filepond-polyfill/dist/filepond-polyfill.min.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>


    <script src="https://cdn.lucacastelnuovo.nl/instakilo.lucacastelnuovo.nl/js/filepond.3.js"></script>
HTML;

page_footer($extra);

?>
