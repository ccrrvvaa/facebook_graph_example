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
$permissions = ['user_posts'];
$loginUrl = $helper->getLoginUrl(SETTINGS['callback'], $permissions);

include_once __DIR__ . '/header.php'; ?>

<main>
    <div style="text-align: center;">
        <a href="<?= $loginUrl ?>" class="fa fa-facebook">
            <span>Login</span>
        </a>
    </div>
</main>

<?php
include_once __DIR__ . '/footer.php';