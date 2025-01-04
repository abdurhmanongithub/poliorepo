<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class Constants
{
    const ATTRIBUTE_TYPES = [
        'text',
        'numeric',
        'image',
        'date'
    ];
    const BROADCAST_STATUS_PENDING = 0;
    const BROADCAST_STATUS_SENT = 1;
    const BROADCAST_STATUS_FAILED = 2;
    const EXPORT_TYPE_CSV = 'csv';
    const EXPORT_TYPE_EXCEL = 'xlsx';
    const EXPORT_TYPE_PDF = 'pdf';
    const EXPORT_TYPE_HTML = 'html';

    const OTHER_DATA_SOURCE_CORE_GROUP_DATA = 'Core Group Data';
    const OTHER_DATA_SOURCE_AFP_DATA = 'AFP EPHI DATA';

    const EXPORT_TYPES = [
        Constants::EXPORT_TYPE_CSV => 'CSV',
        Constants::EXPORT_TYPE_EXCEL => 'EXCEL',
        Constants::EXPORT_TYPE_PDF => 'PDF',
        Constants::EXPORT_TYPE_HTML => 'HTML',
    ];
    const ROLE_APPROVER = 'Approver';
    const RESEARCHER_USER = 0;
    const EXTERNAL_USER = 1;
    const INTERNAL_USER = 1;
    const USER_TYPES = [
        Constants::RESEARCHER_USER => 'Researcher User',
        Constants::EXTERNAL_USER => "External User",
        Constants::INTERNAL_USER => "Internal User",
    ];

    const SUPER_ADMIN = 'super-admin';
    const INFORMATION = 1;
    const MESSAGE = 2;
    static function sendGeezSms($phone, $message, $shortcode_id = null, $callback_url = null)
    {
        $apiToken = env('GEEZSMS_API_TOKEN');
        $endpoint = 'https://api.geezsms.com/api/v1/sms/send';

        // Prepare the form-data body
        $data = [
            'token' => $apiToken,
            'phone' => $phone,
            'msg' => $message,
            'callback' => url('/sms-callback'),
        ];
        // dump($data);

        // Add optional parameters if provided
        if ($shortcode_id) {
            $data['shortcode_id'] = $shortcode_id;
        }
        if ($callback_url) {
            $data['callback'] = $callback_url;
        }

        // Send the POST request using Laravel's HTTP client
        $response = Http::asForm()->post($endpoint, $data);

        // Return the response
        return $response->json();
    }
    static function sendSms($phone, $msg)
    {
        return true;
        if (preg_match('/^\d{2}/', $phone)) {
            $phoneNumber = '2519' . substr($phone, 2);
        } else {
            $phoneNumber = preg_replace('/^\+/', '', $phone);
        }
        $client = new Client();
        $response = $client->request('POST', env('SMS_API'), [
            'form_params' => [
                'token' => env('SMS_API'),
                'phone' => $phoneNumber,
                'msg' => $msg,
            ],
        ]);
        $obj = json_decode($response->getBody());

        if ($obj->error) {
            return false;
        } else {
            // There is no error.
            return true;
        }
    }
}
