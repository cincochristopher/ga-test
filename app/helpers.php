<?php

if (! function_exists('remember')) {
    function remember($key, $minutes, $return)
    {
        return Cache::remember($key, $minutes, function () use ($return) {
            return $return;
        });
    }
}

if (! function_exists('key_builder')) {
    function key_builder(Illuminate\Http\Request $request)
    {
        return $request->path() . '?' . http_build_query($request->all());
    }
}
