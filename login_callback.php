<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/settings_local.php';

if(!session_id()) {
    session_start();
}

$fb = new \Facebook\Facebook([
    'app_id' => SETTINGS['app_id'],
    'app_secret' => SETTINGS['app_secret'],
    'default_graph_version' => SETTINGS['app_version'],
    //'default_access_token' => '{access-token}', // optional
]);

$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    $message = 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    $message = 'Facebook SDK returned an error: ' . $e->getMessage();
}

if(isset($accessToken)) {
    $client = $fb->getOAuth2Client();
    try {
        // Returns a long-lived access token
        $accessTokenLong = $client->getLongLivedAccessToken($accessToken);
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // There was an error communicating with Graph
        $message = $e->getMessage();
    }

    if (isset($accessTokenLong)) {
        $_SESSION['access_token'] = $accessTokenLong;
        header('Location: index.php');
        exit;
    } else {
        $message = "No existe el long lived access token";
    }
} else {
    $message = "No existe el access token";
}

include_once __DIR__ . '/header.php'; ?>

<main>
    <p class="bg-danger" style="text-align: center;">
        <?= $message ?>
    </p>
</main>

<?php
include_once __DIR__ . '/footer.php';