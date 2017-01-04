<?php

if (! function_exists('remember')) {
    function remember($key, $minutes, $value)
    {
        return Cache::remember($key, $minutes, function () use ($value) {
            return $value;
        });
    }
}

if (! function_exists('remember_forever')) {
    function remember_forever($key, $value)
    {
        return Cache::rememberForever($key, function () use ($value) {
            return $value;
        });
    }
}

if (! function_exists('key_builder')) {
    function key_builder(Illuminate\Http\Request $request)
    {
        return $request->path() . '?' . http_build_query($request->all());
    }
}

if (! function_exists('redis_scan')) {
    function redis_scan($pattern, $cursor = null, $allResults = array())
    {
        // Zero means full iteration
        if ($cursor==="0") {
            return $allResults;
        }

        // No $cursor means init
        if ($cursor===null) {
            $cursor = "0";
        }

        // The call
        $result = Illuminate\Support\Facades\Redis::scan($cursor, 'match', $pattern);

        // Append results to array
        $allResults = array_merge($allResults, $result[1]);

        // Recursive call until cursor is 0
        return redis_scan($pattern, $result[0], $allResults);
    }
}
