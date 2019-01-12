<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <link href="/manifest.json" rel="manifest">
    <meta content="#ff7043" name="theme-color">
    <title>Home</title>

    <meta content="InstaKilo" name="description">
    <meta content="InstaKilo, Insta Kilo" name="keywords">

    <!-- Tells Google not to provide a translation for this document -->
    <meta content="notranslate" name="google">

    <!-- Control the behavior of search engine crawling and indexing -->
    <meta content="index,follow" name="robots">
    <meta content="index,follow" name="googlebot">

    <!-- Favicons/Icons -->
    <link href="/favicon.ico" rel="shortcut icon">
    <link href="/favicon.png" rel="icon" sizes="192x192">
    <link href="/favicon.png" rel="apple-touch-icon">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.lucacastelnuovo.nl/general/css/materialize.css" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="nav-wrapper deep-orange lighten-1">
            <a class="brand-logo" href="/home" style="padding-left: 15px">Direct messages</a> <a class="right sidenav-trigger" data-target="sidenav" href="#"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <a href="/user/settings">Settings</a>
                </li>
                <li>
                    <a href="/?logout">Logout</a>
                </li>
            </ul>
        </div>
        <ul class="sidenav" id="sidenav">
            <li>
                <a href="/home">Home</a>
            </li>
            <li>
                <a href="/user/settings">Settings</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="/?logout">Logout</a>
            </li>
        </ul>
    </nav>
    <ul class="collection collapsible">
				<li class="collection-item avatar">
					<div class="collapsible-header">
            <img alt="" class="circle" src="https://images-na.ssl-images-amazon.com/images/I/81-yKbVND-L.png">
            <p>
                Username<br>
                Last message
            </p>
					</div>
        </li>
				<li>
			<div class="collapsible-body">
        <li style="list-style: none; display: inline">
            <div class="margin-custom col s12 m8 offset-m2 l6 offset-l3">
                <div class="card-panel grey lighten-5 z-depth-1">
                    <div class="row">
                        <div class="col s12 m10">
                            <div class="card-panel teal">
                                <span class="white-text">I am a very simple card. I am good at containing small bits of information.
                                    I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
                                </span>
                            </div>
                        </div>
                        <div class="m2"></div>
                    </div>
                    <div class="row">
                        <div class="col s12 m10 offset-m2">
                            <div class="card-panel">
                                <span class="black-text">I am a very simple card. I am good at containing small bits of information.
                                    I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
			</div>
		</li>
        <li class="collection-item avatar">
            <i class="material-icons circle">folder</i> <span class="title">Title</span>
            <p>
                First Line<br>
                Second Line
            </p>
        </li>
        <li class="collection-item avatar">
            <i class="material-icons circle green">insert_chart</i> <span class="title">Title</span>
            <p>
                First Line<br>
                Second Line
            </p>
        </li>
        <li class="collection-item avatar">
            <i class="material-icons circle red">play_arrow</i> <span class="title">Title</span>
            <p>
                First Line<br>
                Second Line
            </p><a class="secondary-content" href="#!">
        </li>
    </ul>

    <ul class="collapsible">
        <li>
            <div class="collapsible-header"><i class="material-icons">filter_drama</i>First</div>
            <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">place</i>Second</div>
            <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">whatshot</i>Third</div>
            <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
        </li>
    </ul>


    <style>
        .margin-custom {
            margin-right: 5%;
            margin-left: 5%;
        }
    </style>
    <script src="https://cdn.lucacastelnuovo.nl/general/js/materialize.js"></script>
    <script src="https://test.lucacastelnuovo.nl/users/ltcastelnuovo/instakilo/init.js"></script>
    <script>
        M.AutoInit(document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.collapsible');
            var instances = M.Collapsible.init(elems, {});
        }));
    </script>
</body>

</html>
