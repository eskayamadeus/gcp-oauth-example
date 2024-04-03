<?php

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth-complete', function () {
    $meetClientIdPath = base_path('client_secret.json');
    $authCode = request()->input('code');
    $userId = auth()->id();

    $client = new \Google\Client();
    $client->setAuthConfig($meetClientIdPath);
    $client->setRedirectUri('https://redirectmeto.com/http://gcp-oauth-example.test/auth-complete');

    $response = $client->fetchAccessTokenWithAuthCode($authCode);

    Redis::set('meet_refresh_token_'.$userId, $response['access_token']);
    Redis::set('meet_access_token_'.$userId, $response['refresh_token']);

    return view('authcomplete');
});
