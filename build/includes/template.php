<?php

function page_header($title = 'Unknown')
{
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Config -->
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="manifest" href="/manifest.json" />
        <meta name="theme-color" content="#2962ff">
        <title>{$title}</title>

        <!-- SEO -->
        <meta name="description" content="InstaKilo is een leuke manier om je foto's te delen.">
        <meta name="keywords" content="InstaKilo">

        <!-- Styles -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!-- TODO: add cdn link -->
        <link rel="stylesheet" href="https://instakilo.lucacastelnuovo.nl/css/style.css" />

        <!-- Analytics -->
        <script type="text/javascript">
            var _paq = window._paq || [];
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u="//analytics.lucacastelnuovo.nl/";
                _paq.push(['setTrackerUrl', u+'matomo.php']);
                _paq.push(['setSiteId', '9']);
                var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
            })();
        </script>
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
                        <li><a href="/?logout"><i class="material-icons">exit_to_app</i></a></li>
                    </ul>
                </div>
            </nav>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <!-- TODO: add cdn link -->
        <script src="https://instakilo.lucacastelnuovo.nl/js/app.js"></script>
        <script src="/sw-register.js"></script>
HTML;
    alert_display();
    echo <<<HTML
    </body>

    </html>
HTML;
}
