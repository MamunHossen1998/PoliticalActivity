<?php
use Illuminate\Support\Facades\Route;

Route::pattern('segment', '[A-Za-z0-9_-]+');
Route::middleware(['web', 'auth', 'ensure.segment'])->prefix('{segment}')->group(function () {

});
