<?php

use Illuminate\Support\Facades\Storage;

function success($data = null, $message = null, $statusCode = 200)
{
    $message = $message ?: __('Success');

    return response()->json([
        'data' => $data,
        'message' => $message,
    ], $statusCode);
}

function problem($message = null, $statusCode = 400, $code = null)
{
    $message = $message ?: __('Some problem occured');

    return response()->json([
        'message' => $message,
        'code' => $code,
    ], $statusCode);
}

function uploadImage($file, $dir)
{
    // upload new image
    return Storage::put($dir, $file);
}

function imageUrl($dir, $image)
{
    if ($image != null && file_exists(Storage::path($dir . '/' . $image))) {
        $url = asset('storage/' . $dir . '/' . $image);
    } else {
        $url = null;
    }
    return $url;
}
