<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

page_header('Home');
?>
<div class="row">
    <div class="col s12 l7">
        <div class="row">

            <!-- POST -->
            <div class="col s12">
                <div class="card">
                    <div class="card-image"><img src="https://i.imgur.com/DshghpU.jpg"></div>
                    <div class="card-content">
                        <p><b>INSERT CAPTION HERE</b></p>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <a href="#"><i class="material-icons blue-icon">thumb_up</i></a> 100 likes
                        </div>
                        <div class="row mb-0">
                            <ul class="collection">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle">account_circle</i> <span class="title">FirstName Last Name</span>
                                    <p class="truncate">I want to learn this kind of shot! Teach me.</p><a class="secondary-content" href="#!"><i class="material-icons blue-icon">thumb_up</i></a>
                                </li>
                                <li class="collection-item avatar">
                                    <i class="material-icons circle">account_circle</i> <span class="title">FirstName Last Name</span>
                                    <p class="truncate">Nice use of white in this colour palette!!</p><a class="secondary-content" href="#!"><i class="material-icons blue-icon">thumb_up</i></a>
                                </li>
                            </ul>
                            <form action="">
                                <div class="row mb-0">
                                    <div class="col s12 m9">
                                        <div class="input-field col s12 mb-0">
                                            <label for="comment">Comment</label>
                                            <textarea id="comment" class="materialize-textarea counter" name="comment" data-length="200"></textarea>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 m3">
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
    <div class="col l1"></div>
    <div class="col l4 hide-on-small-only">
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
<?= page_footer() ?>
