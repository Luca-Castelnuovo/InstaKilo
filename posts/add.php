<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

page_header('Create Post');
?>

<!-- imgur css -->
<div class="row">
    <div class="col s12">
        <div class="center-align">
            <h1>Upload Foto</h1>
            <input type="hidden" id="CSRFtoken" name="CSRFtoken" value="<?= csrf_gen(); ?>">
        </div>
        <div class="dropzone">
            <div class="info">
                <div class="preloader-wrapper big hide">
                    <div class="spinner-layer spinner-green-only color-primary--border hover-disable">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ajax js -->
<!-- imgur js -->

<?php
$CSRFtoken = csrf_gen();
$extra = <<<HTML
<script>
    var CSRFtoken = '{$CSRFtoken}'; var auto_init = true;
</script>
HTML;

page_footer($extra);

?>
