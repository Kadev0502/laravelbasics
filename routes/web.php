<?php

use Illuminate\Support\Facades\Route;


Route ::get('/', function() {
    return 'Homepage';
});


Route ::group(['prefix'=>'/user'], function() {

    Route ::get('/login', function() {
        return 'Welcome';
    });

    Route ::get('/password', function() {
        return 'Password';
    });

    Route ::get('/logout', function() {
        return 'Bye Bye';
    });
});

