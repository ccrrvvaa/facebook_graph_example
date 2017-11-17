<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/settings_local.php';

if(!session_id()) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$fb = new \Facebook\Facebook([
    'app_id' => SETTINGS['app_id'],
    'app_secret' => SETTINGS['app_secret'],
    'default_graph_version' => SETTINGS['app_version'],
    //'default_access_token' => '{access-token}', // optional
]);

include_once __DIR__ . '/header.php';

if(isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $accessToken = $_SESSION['access_token'];
    try {
        // Get the \Facebook\GraphNodes\GraphUser object for the current user.
        // If you provided a 'default_access_token', the '{access-token}' is optional.
        $response = $fb->get('/me', $accessToken);
    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        $meesage = 'Graph returned an error: ' . $e->getMessage();
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        $meesage =  'Facebook SDK returned an error: ' . $e->getMessage();
    }
    
    if($response) {
        $me = $response->getGraphUser();
        //echo 'Logged in as ' . $me->getId() . " - " . $me->getName();

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get(
                '/me/posts?fields=id,message,story,link,full_picture&limit=15',
                $accessToken
            );
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            $meesage = 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            $meesage = 'Facebook SDK returned an error: ' . $e->getMessage();
        }
        
        // Page 1
        $feeds = $response->getGraphEdge();

        ?>
        <main>
            <div class="row">
                <?php foreach ($feeds as $feed): 
                    $data = $feed->asArray(); ?>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <?php if(isset($data['full_picture'])): ?>
                                <a target="_blank" href="<?= $data['link'] ?? '#' ?>"><img src="<?= $data['full_picture'] ?>" alt="..."></a>
                            <?php endif; ?>
                            <div class="caption">
                                <?php if(isset($data['story'])): ?>
                                    <div>
                                        <p><?= $data['story'] ?></p>
                                    </div>
                                <?php endif;
                                if(isset($data['message'])): ?>
                                    <div>
                                        <p><?= $data['message'] ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        
        <?php
        // Page 2 (next 5 results)
        /*$nextFeed = $fb->next($feedEdge);

        foreach ($nextFeed as $status) {
            var_dump($status->asArray());
        }*/
    } else { ?>
        <main>
            <p class="bg-danger" style="text-align: center;">
                <?= $message ?>
            </p>
        </main>
    <?php }
} else {
    header('Location: login.php');
    exit;
}

include_once __DIR__ . '/footer.php';