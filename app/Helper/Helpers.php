<?php

function sendResponse ($status,$ErrorCode, $errors = [], $code =200 ) {

    return response()->json([
        'Status' => $status,
        'ErorrCode' => $ErrorCode,
        'errors' => $errors,
    ],$code);
}