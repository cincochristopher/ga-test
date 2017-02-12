<?php

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
        $result = Illuminate\Support\Facades\Redis::scan($cursor, 'MATCH', $pattern);

        // Append results to array
        $allResults = array_merge($allResults, $result[1]);

        // Recursive call until cursor is 0
        return redis_scan($pattern, $result[0], $allResults);
    }
}
