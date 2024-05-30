<?php

namespace App\Http\Controllers;

use App\Models\SmsHistory;
use App\Http\Requests\StoreSmsHistoryRequest;
use App\Http\Requests\UpdateSmsHistoryRequest;
use Illuminate\Http\Request;

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
    public function store(StoreSmsHistoryRequest $request)
    {
        //
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
    public function smsModule(Request $request)
    {
        //
        return view('sms_module.index');
    }

}
