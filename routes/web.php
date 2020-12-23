<?php

use Illuminate\Support\Facades\Route;


Route ::get('/', function() {
    return 'Homepage';
});

Route ::get('/users/{username}', function($username) {

    return $username;
});

