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
$permissions = ['user_posts'];
$loginUrl = $helper->getLoginUrl($settings['callback'], $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';