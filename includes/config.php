<?php

$configKey = getenv('CONFIG_KEY');
$configClient = new \ConfigCat\ConfigCatClient($configKey);

if (!$configClient->getValue("appActive", true)) {
    http_response_code(503);
    exit('App is temporarily disabled.');
}

return (object) array(
    'database' => (object) array(
        'host' => $configClient->getValue("dbHost", "localhost"),
        'user' => $configClient->getValue("dbUser", ""),
        'password' => $configClient->getValue("dbPassword", ""),
        'database' => $configClient->getValue("dbDatabase", ""),
    ),

    'client' => (object) array(
        'id' => $configClient->getValue("clientID", ""),
        'secret' => $configClient->getValue("clientSecret", ""),
    ),

    'imgur_key' => $configClient->getValue("imgurKey", ""),
);
