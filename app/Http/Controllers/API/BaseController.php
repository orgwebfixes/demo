<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'status' => true,
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        if (!empty($result)) {
            $response['data'] = $result;
        }
        \Log::info('Success: ');
        \Log::info($response);
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($errorMessages = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $errorMessages,
        ];
        \Log::info('Error: ');
        \Log::info($response);
        /*if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }*/
        return response()->json($response, $code);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendOldResponse($result, $message)
    {
        $response = [
            'status' => 'true',
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        if (!empty($result)) {
            $response['data'] = $result;
        }
        \Log::info('Success: ');
        \Log::info($response);
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendOldError($errorMessages = [], $code = 400)
    {
        $response = [
            'status' => 'Failed',
            'message' => $errorMessages,
        ];
        \Log::info('Error: ');
        \Log::info($response);
        return response()->json($response, $code);
    }
}
