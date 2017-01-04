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

$app->get('/', function (Request $request) use ($app) {
    return $app->version();
});

$app->get('/programs', function (Request $request) {
    $programs = Program::take(5)->get();
    return response()->json(remember_forever($request->getUri(), $programs));
});

$app->get('/programs/{id}', function (Request $request, $id) {
    $program = Program::where('clientID', $id)->first();
    return response()->json(remember_forever($request->getUri(), $program));
});

$app->get('/invalidate', function () {
    $pattern = '*/programs/1226*';
    foreach (redis_scan($pattern) as $key) {
        Redis::del($key);
    }
});

$app->get('/provider/{providerAlias}', 'ProviderController@getProvider');
