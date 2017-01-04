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
    $key = $request->getUri();

    $programs = Cache::rememberForever($key, function () {
        return Program::take(5)->get();
    });

    return response()->json($programs);
});

$app->get('/programs/{id}', function (Request $request, $id) {
    $key = $request->getUri();
    $program = Cache::rememberForever($key, function () use ($id) {
        return Program::where('clientID', $id)->first();
    });
    return response()->json($program);
});

$app->get('/invalidate/programs/{id}', function ($id) {
    $pattern = "*/programs/$id";
    Redis::pipeline(function ($pipe) use ($pattern) {
        foreach (redis_scan($pattern) as $key) {
            $pipe->del($key);
        }
    });
});

$app->get('/provider/{providerAlias}', 'ProviderController@getProvider');
