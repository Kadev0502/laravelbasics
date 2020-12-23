<?php

use Illuminate\Support\Facades\Route;


Route ::get('/', function() {
    return 'Homepage';
});

Route ::get('/about', function() {
    return 'About Page';
}) -> name('about');
