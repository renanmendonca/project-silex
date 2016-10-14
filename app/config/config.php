<?php

if(isset($_SERVER['ENV']) && $_SERVER['ENV'] == 'dev'){
	// enable the debug mode
	$app['debug'] = true;
}

// Instagram Access Token
$app['instagram.access_token'] = '847573489.faa8411.f2877cda6ddd491fb26646c5589d17be';
$app['instagram.base_uri'] = 'https://api.instagram.com/v1/tags/';