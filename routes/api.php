<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth-url', function () {
    $client = new \Google\Client();
    $client->setAuthConfig(base_path('client_secret.json'));
    $client->addScope('profile');
    $client->setRedirectUri('https://redirectmeto.com/http://gcp-oauth-example.test');
    $client->setAccessType('offline');
    $client->setIncludeGrantedScopes(true);
    // $client->setLoginHint('skelikem@gmail.com');
    $auth_url = $client->createAuthUrl();

    return redirect()->away(filter_var($auth_url, FILTER_SANITIZE_URL));
    // return $auth_url;
});
