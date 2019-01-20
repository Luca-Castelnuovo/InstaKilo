<?php

function page_header($title = 'Unknown')
{
    echo <<<HTML
    <!DOCTYPE html>
    <html>

    <head>
        <!-- Config -->
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="manifest" href="/site.webmanifest"></link>
        <title>{$title}</title>

        <!-- SEO -->
        <link href="https://instakilo.lucacastelnuovo.nl" rel="canonical">
        <meta content="A system to store and access all my logs" name="description">

        <!-- Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

        <!-- Styles -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <link rel="stylesheet" href="https://cdn.lucacastelnuovo.nl/general/css/materialize.css" />
        <link rel="stylesheet" href="https://cdn.lucacastelnuovo.nl/instakilo.lucacastelnuovo.nl/css/style.7.css" />
    </head>

    <body>
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper blue accent-4">
                    <a href="/home" class="brand-logo" style="padding-left: 15px">{$title}</a>
                    <a href="#" data-target="sidenav" class="right sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="/users" class="tooltipped" data-position="bottom" data-tooltip="Users"><i class="material-icons">group</i></a></li>
                        <li><a href="/messages" class="tooltipped" data-position="bottom" data-tooltip="Messages"><i class="material-icons">message</i></a></li>
                        <li><a href="/u/{$_SESSION['user_name']}" class="tooltipped" data-position="bottom" data-tooltip="Profile"><i class="material-icons">person</i></a></li>
                        <li><a href="/?logout" class="tooltipped"><i class="material-icons">exit</i></a></li>
                    </ul>
                </div>

                <ul class="sidenav" id="sidenav">
                    <li><a href="/home">Home</a></li>
                    <li class="divider"></li>
                    <li><a href="/users">Users</a></li>
                    <li><a href="/messages">Messages</a></li>
                    <li><a href="/u/{$_SESSION['user_name']}">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="/?logout">Logout</a></li>
                </ul>
            </nav>
        </div>
        <div class="section">
            <div class="container">
HTML;
}

function page_footer($extra = null)
{
    echo <<<HTML
            </div>
        </div>
        {$extra}
        <script src="https://cdn.lucacastelnuovo.nl/general/js/materialize.js"></script>
        <script src="https://cdn.lucacastelnuovo.nl/instakilo.lucacastelnuovo.nl/js/app.90.js"></script>
HTML;
    alert_display();
    echo <<<HTML
    </body>

    </html>
HTML;
}
