<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/settings_local.php';

if(!session_id()) {
    session_start();
}

$fb = new \Facebook\Facebook([
    'app_id' => $settings['app_id'],
    'app_secret' => $settings['app_secret'],
    'default_graph_version' => $settings['app_version'],
    //'default_access_token' => '{access-token}', // optional
]);

$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if(isset($accessToken)) {
    $client = $fb->getOAuth2Client();
    try {
        // Returns a long-lived access token
        $accessTokenLong = $client->getLongLivedAccessToken($accessToken);
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // There was an error communicating with Graph
        echo $e->getMessage();
        exit;
    }

    if (isset($accessTokenLong)) {

        try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me', $accessTokenLong);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
        $me = $response->getGraphUser();
        echo 'Logged in as ' . $me->getId() . " - " . $me->getName();
        // TODO Save the $accessTokenLong
    } else {
        echo "No existe el long lived access token";
    }
} else {
    echo "No existe el access token";
}