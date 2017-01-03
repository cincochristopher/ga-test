<?php

use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Redis;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('/programs', function (Request $request) {
    return response()->json(remember(key_builder($request), 60, Program::take(5)->get()));
});

$app->get('/invalidate', function () {
    return;
});

$app->get('/provider/{providerAlias}', 'ProviderController@getProvider');
