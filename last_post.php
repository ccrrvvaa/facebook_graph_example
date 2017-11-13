<?php

try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get(
        '/me/feed',
        '{access-token}'
    );
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$graphNode = $response->getGraphNode();
var_dump($graphNode);