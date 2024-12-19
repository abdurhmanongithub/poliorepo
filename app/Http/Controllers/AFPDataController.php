<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Exports\DataImportTemplateExport;
use App\Http\Requests\StoreAFPDataRequest;
use App\Http\Requests\UpdateAFPDataRequest;
use App\Imports\AFPDataImport;
use App\Imports\AFPDataImportForPreview;
use App\Models\AFPData;
use App\Models\Broadcast;
use App\Models\Community;
use App\Models\CommunityType;
use App\Models\Content;
use App\Models\OtherDataSource;
use App\SmsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class AFPDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('afp-data.index', [
            'totalDatas' => AFPData::count(),
            'columnCount' => count(Schema::getColumnListing('a_f_p_data')),
        ]);
    }

    function dataManagement()
    {
        return view('afp-data.data-manage', [
            'totalDatas' => AFPData::count(),
            'columns' => Schema::getColumnListing('a_f_p_data'),
            'columnCount' => count(Schema::getColumnListing('a_f_p_data')),
        ]);
    }
    public function importView()
    {

        return view('afp-data.data.import', [
            'totalDatas' => AFPData::count(),
            'columnCount' => count(Schema::getColumnListing('a_f_p_data')),
        ]);
    }
    public function importPreview(Request $request)
    {
        $schemaList = Schema::getColumnListing('a_f_p_data') ?? [];
        if (count($schemaList) == 0) {
            return redirect()->back()->with('error', 'No column found for this schema');
        }
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv', // Validate file type
        ]);
        $filePath = $request->file('excel_file')->store('temp');
        $keys = [];
        foreach ($schemaList as $item) {
            $keys[] = \Str::slug($item, '_');
        }
        $keys = array_diff($keys, ['id', 'other_data_source_id', 'updated_at', 'created_at']);
        // dd($keys);
        $import = new AFPDataImportForPreview($keys, 10);
        $excelData = Excel::toArray($import, $request->file('excel_file'));
        return view('afp-data.data.import-preview', [
            'totalDatas' => AFPData::count(),
            'columnCount' => count(Schema::getColumnListing('a_f_p_data')),
            'excelData' => $excelData,
            'keys' => $keys,
            'filePath' => $filePath
        ]);
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 6000);
        $filePath = $request->input('file_path');
        $otherDataSource = OtherDataSource::create([
            'import_batch' => AFPData::getNextDataSource(),
            'source' => Constants::OTHER_DATA_SOURCE_AFP_DATA,
        ]);
        $keys = [];
        foreach (Schema::getColumnListing('a_f_p_data') as $item) {
            $keys[] = \Str::slug($item, '_');
        }
        Excel::import(new AFPDataImport($otherDataSource, $keys), storage_path('app/' . $filePath));
        return redirect()->route('afp-data.data-management')->with('success', 'Data imported successfully');
    }
    public function datafetch()
    {
        $data = AFPData::query();
        return datatables()->of($data->get())->toJson();
    }
    public function importTemplateDownload()
    {

        $headers = Schema::getColumnListing('a_f_p_data');
        $headers = array_diff($headers, ['id', 'other_data_source_id', 'created_at', 'updated_at']);
        return Excel::download(new DataImportTemplateExport($headers), 'a_f_p_data_import_template.xlsx');
    }
    public function dataSource()
    {
        $sources = OtherDataSource::whereIn('id', AFPData::distinct('other_data_source_id')->pluck('other_data_source_id'))->get();
        return view('afp-data.source', compact('sources'));
    }
    public function dataSourceDelete(OtherDataSource $source)
    {
        DB::table('a_f_p_data')->where('other_data_source_id', $source->id)->delete();
        $source->delete();
        return redirect()->back()->with('success', 'Data Source Deleted Successfully');
    }

    public function content()
    {
        $contents = Content::where('type', 'afp')->get();
        return view('afp-data.content', compact('contents'));
    }
    public function contentStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'language' => 'required',
        ]);
        $data['type'] = 'afp';
        Content::create($data);
        session()->flash('success', 'Content added successfully!');
        return response()->json(['success' => true, 'message' => 'Content added successfully!']);
    }
    public function contentUpdate(Request $request, Content $content)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'language' => 'required',
        ]);
        $content->update($data);
        session()->flash('success', 'Content updated successfully!');
        return response()->json(['success' => true, 'message' => 'Content updated successfully!']);
    }

    public function contentDelete(Content $content)
    {
        $content->delete();
        session()->flash('success', 'Content deleted successfully!');
        return response()->json(['success' => true, 'message' => 'Content deleted successfully!']);
    }

    public function contentShow(Content $content)
    {
        $notifications = Broadcast::where('content_id', $content->id)->get();
        $communityTypes = CommunityType::all();
        $communities = Community::all();
        return view('afp-data.content-show', compact('content', 'notifications', 'communities', 'communityTypes'));
    }
    public function notify(Content $content, Request $request)
    {
        $data = $request->validate([
            'send_by' => 'required',
            'community_type' => 'required_if:send_by,0',
            'communities' => 'required_if:send_by,1',
            'csv' => 'required_if:send_by,2',
        ]);
        $broadcasts = [];
        switch ($data['send_by']) {
            case 0:
                $members = Community::where('community_type_id', $data['community_type'])->get();
                foreach ($members as $member) {
                    $broadcast = BroadCast::create([
                        'content_id' => $content->id,
                        'community_id' => $member->id,
                        'phone' => $member->phone,
                        'status' => Constants::BROADCAST_STATUS_PENDING,
                    ]);
                    array_push($broadcasts, $broadcast);
                }
                break;
            case 1:
                $members = Community::whereIn('community_type_id', $data['communities'])->get();
                foreach ($members as $member) {
                    $broadcast = BroadCast::create([
                        'content_id' => $content->id,
                        'community_id' => $member->id,
                        'phone' => $member->phone,
                        'status' => Constants::BROADCAST_STATUS_PENDING,
                    ]);
                    array_push($broadcasts, $broadcast);
                }
                break;
            case 2:
                $csv = collect(json_decode($data['csv']))->pluck('value')->toArray();
                foreach ($csv as $phone) {
                    $broadcast = BroadCast::create([
                        'content_id' => $content->id,
                        'phone' => $phone,
                        'status' => Constants::BROADCAST_STATUS_PENDING,
                    ]);
                    array_push($broadcasts, $broadcast);
                }
                break;
        }
        foreach ($broadcasts as $broadcast) {
            // SmsHelper::sendSms($broadcast->phone, $content->content);
        }
        return redirect()->back()->with('success', 'Broadcast send successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAFPDataRequest $request, AFPData $aFPData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AFPData $aFPData)
    {
        //
    }
}
