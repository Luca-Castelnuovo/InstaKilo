<?php

//Set default head for a page
function head($title)
{
    echo <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <title>{$title}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
    //INSERT NAVBAR HERE
HTML;
}

//Set default footer for a page
function footer()
{
    echo <<<HTML
        //INSERT FOOTER HERE
HTML;
    alert_display();
    echo <<<HTML
    </body>
    </html>
HTML;
}
