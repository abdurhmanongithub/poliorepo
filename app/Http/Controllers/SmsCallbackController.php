<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SmsCallbackController extends Controller
{
    //
    public function handleCallback(Request $request)
    // public function handleCallback(Request $request)
    {
        // Log the callback for debugging (optional)
        Log::info('SMS Callback Received:', $request->all());

        // Extract the callback data
        $status = $request->input('message_status');
        $phone = $request->input('phone');
        $message = $request->input('message');
        $logId = $request->input('api_log_id');

        // Example: Save to the database (optional)
        DB::table('sms_logs')->insert([
            'phone' => $phone,
            'message' => $message,
            'status' => $status,
            'api_log_id' => $logId,
            'created_at' => now(),
        ]);

        // Return a response to GeezSMS
        return response()->json(['message' => 'Callback received successfully'], 200);
    }
}
