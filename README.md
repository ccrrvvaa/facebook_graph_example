# Showing the last posts from a facebook account using PHP 7

This is a simple example of creating a website in which I can show the last posts created in a facebook account. You have to follow the next steps:

- Create a Facebook App (https://developers.facebook.com/docs/apps/register/)
- Install external libraries using `composer install` (The only library used here is the Facebook Sdk for Graph Api: https://github.com/facebook/php-graph-sdk)
- Create a file called: **settings_local.php** with the following content:
```php
<?php
define('SETTINGS', [
    "app_id" => "<Your Facebook App Id>",
    "app_secret" => "<Your Faceook App Secret>",
    "app_version" => "<Graph Api version of your Facebook App>",
    "callback" => "http://yourlocalhost/login_callback.php"
]);
```
- This code needs to be executed with PHP 7 since there are few small parts of code using the new features of this php version.
- Upload this on a web server (Nginx, Apache or with the built-in php server for testing purposes). In the case of testing purposes, execute the following comand in the root of the project:
`php -S localhost:8000`

*Note: You need to give access to the Facebook App to get information from your facebook account in order to show your information when you are testing this.*