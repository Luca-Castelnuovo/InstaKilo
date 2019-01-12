<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

page_header('Home');
?>

<link rel="stylesheet" href="/css/style.css">

<div class="row">
    <div class="col s12 l7">
        <div class="row">
            <div class="row">
                <!-- CREATE POST BTN -->
                <div class="fixed-action-btn">
                    <a class="btn-floating btn-large waves-effect waves-light blue accent-4" href="/posts/add">
                        <i class="large material-icons">camera_alt</i>
                    </a>
                </div>
            </div>

            <div class="row" id="post_container">


                <!-- POST -->
                <div class="col s12">
                    <div class="card">
                        <div class="card-image"><img id="post_image" src="https://i.imgur.com/DshghpU.jpg"></div>
                        <div class="card-content">
                            <p><span id="post_owner"><a href="/u/ltcastelnuovo" class="black-text">Luca Castelnuovo</a></span> <span id="post_caption">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut elit et dui ornare porttitor quis ac dui. Quisque gravida porttitor nunc eu lacinia. Etiam consectetur at lorem vel ultrices. Etiam quis vulputate ipsum, vitae ornare est. Cras ac ultrices elit. Sed eleifend tristique efficitur. Mauris sagittis hendrerit ante, ac commodo nisl feugiat sed. Vestibulum in erat elementum mi sodales lobortis.</span></p>
                        </div>
                        <div class="card-action">
                            <div class="row mb-0 fs-24">
                                <a href="/posts/actions/?type=like&CSRFtoken=<?= csrf_gen() ?>" class="mr-0"><i class="material-icons blue-icon" id="post_like">favorite_border</i></a><span id="post_likes"><span id="post_likes_count">100</span> likes</span>
                            </div>
                            <div class="row mb-0">
                                <ul class="collection">


                                    <!-- COMMENTS -->
                                    <li class="collection-item avatar">
                                        <i class="material-icons circle">account_circle</i> <span class="title">FirstName Last Name</span>
                                        <p class="truncate">I want to learn this kind of shot! Teach me.</p>
                                    </li>
                                    <li class="collection-item avatar">
                                        <i class="material-icons circle">account_circle</i> <span class="title">FirstName Last Name</span>
                                        <p class="truncate">Nice use of white in this colour palette!!</p>
                                    </li>


                                </ul>
                                <form action="/posts/actions" method="POST">
                                    <div class="row mb-0">
                                        <div class="col s12 m9">
                                            <div class="input-field col s12 mb-0">
                                                <label for="form_comment">Comment</label>
                                                <textarea id="form_comment" class="materialize-textarea counter" name="comment" data-length="200"></textarea>
                                            </div>
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <input type="hidden" name="CSRFtoken" value="<?= csrf_gen() ?>">
                                            <button class="btn waves-effect waves-light col s12 blue accent-4" name="action" type="submit">Send <i class="material-icons right">send</i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="col l1"></div>
    <div class="col l4 hide-on-med-and-down">
        <div class="row">
            <a class="col s12 btn-large waves-effect blue accent-4" href="#!">
            <h5>Berichten</h5></a>
        </div>
        <div class="row">
            <ul class="collection">
                <li class="collection-item avatar">
                    <i class="material-icons circle">account_circle</i> <span class="title">FirstName Last Name</span>
                    <p class="truncate">Layers, background, shot, concept – good!</p><a class="secondary-content" href="#!"><i class="material-icons blue-icon">message</i></a>
                </li>
                <li class="collection-item avatar">
                    <i class="material-icons circle">account_circle</i> <span class="title">FirstName Last Name</span>
                    <p class="truncate">Mission accomplished. It's revolutionary.</p><a class="secondary-content" href="#!"><i class="material-icons blue-icon">message</i></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= page_footer('<script src="/js/home.js"></script>') ?>
