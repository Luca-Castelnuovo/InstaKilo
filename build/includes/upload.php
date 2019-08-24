<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';
loggedin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    reponse(false, 'invalid_method');
}

$mimetype = mime_content_type($_FILES['post_img']['tmp_name']);
$allowed_mime_types = [
    'image/png',
    'image/jpg',
    'image/jpeg'
];

if (!in_array($mimetype, $allowed_mime_types)) {
    echo 'Upload a real image, jerk!';
    exit;
}

$image = file_get_contents($_FILES['post_img']['tmp_name']);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Authorization: Client-ID ' . $GLOBALS['config']->imgur_key ));
curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'image' => base64_encode($image) ));

$reponse = curl_exec($ch);
curl_close($ch);

$reponse = json_decode($reponse);
echo $reponse->data->link;
