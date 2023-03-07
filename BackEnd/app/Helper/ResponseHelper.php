<?php

use App\Http\Resources\MasterMaterialResource;

use function PHPUnit\Framework\isNull;

if (!function_exists('GeneratePayload')) {
    function GeneratePayload($ResponseData, $resourceName = null)
    {
        $resourceName = "App\\Http\\Resources\\" . $resourceName;

        return [
            "status" => isset($ResponseData[0]) ? $ResponseData[0] : "",
            "messages" => isset($ResponseData[1]) ? $ResponseData[1] : "",
            "payload" => isset($ResponseData[2]) ? $resourceName::collection($ResponseData[2]) : null
        ];
    }
}
