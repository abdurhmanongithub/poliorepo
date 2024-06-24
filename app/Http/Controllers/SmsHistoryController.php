<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Community;
use App\Models\DataSchema;
use App\Models\SmsHistory;
use App\Http\Requests\StoreSmsHistoryRequest;
use App\Http\Requests\UpdateSmsHistoryRequest;
use App\Imports\PhoneImport;
use App\Models\Knowledge;
use App\SmsHelper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SmsHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sms_type = $request->get('sms_type');

        if ($sms_type == Constants::INFORMATION) {
            if ($request->get('type') == 'individual')
                foreach ($request->get('knowledge_ids') as $key => $know_id) {
                    $Know = Knowledge::find($know_id);
                    foreach ($request->get('community_ids') as $key => $id) {
                        $com = Community::find($id);

                        $sms = Constants::sendSms($com->phone, $Know->message);
                        if ($sms) {
                            SmsHistory::create(['type' => Constants::INFORMATION, 'community_id' => $id, 'knowledge_id' => $know_id]);
                        }
                    }
                } else {
                $all_community = DataSchema::find($request->get('data_schema_id'))->subCategory?->communities;

                foreach ($request->get('knowledge_ids') as $key => $know_id) {
                    $Know = Knowledge::find($know_id);
                    foreach ($all_community as $key => $com) {
                        $sms = Constants::sendSms($com->phone, $Know->message);
                        if ($sms) {
                            SmsHistory::create(['type' => Constants::INFORMATION, 'community_id' => $com->id, 'knowledge_id' => $know_id]);
                        }

                    }
                }
            }
        }
        return redirect()->route('data_schema.sms.management', ['data_schema' => $request->get('data_schema_id')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SmsHistory $smsHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SmsHistory $smsHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSmsHistoryRequest $request, SmsHistory $smsHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SmsHistory $smsHistory)
    {
        //
    }
    public function customSmsView()
    {
        //
        return view('sms_module.custom_sms');
    }
    public function customSms(Request $request)
    {
        //
        $phones = $request->get('receiver_phone');
        $message = $request->get('message');
        $array_phones = explode(",", $phones);
        $invalid_phones = [];
        $correct_phones = [];
        $request->validate([
            'receiver_phone' => 'required',
        ]);

        // dd($request);


        foreach ($array_phones as $phone) {
            if (strlen($phone) == 10 || strlen($phone) == 9 || strlen($phone) == 13) {
                if (str_starts_with($phone, '+251')) {
                    array_push($correct_phones, $phone);
                } elseif (str_starts_with($phone, '09')) {
                    $phone = '+251' . ltrim($phone, $phone[0]);
                    array_push($correct_phones, $phone);
                } elseif (str_starts_with($phone, '9')) {
                    $phone = '+251' . $phone;
                    array_push($correct_phones, $phone);
                } else {
                    array_push($invalid_phones, $phone);
                }
            } else {
                array_push($invalid_phones, $phone);
            }
        }
        $correct_phones = array_unique($correct_phones);
        $invalid_phones = array_unique($invalid_phones);
        foreach ($correct_phones as $phone) {
            $sms = Constants::sendSms($phone, $message);
            if (!$sms) {
                return redirect()->back()->with('error', 'Error Occured Durnig Sending Sms ');
            }
            SmsHistory::create(['type' => Constants::MESSAGE, 'phone'=>$phone,'message'=>$message]);

        }
        $error_msg = '';
        if (count($invalid_phones) > 0)
            $error_msg = 'but it' . 'failed to send to the number ' . implode(', ', $invalid_phones);

        return redirect()->back()->with('success', 'The SMS was successfully sent to' . count($correct_phones) . ' phone Number' . $error_msg);
    }

    public function importPhoneNumber(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:2048',
        ]);
        $import = new PhoneImport;
        Excel::import($import, $request->file('file')->store('temp'));
        $phones = $import->phone_string;
        return response()->json(['req' => $phones]);
    }




}
