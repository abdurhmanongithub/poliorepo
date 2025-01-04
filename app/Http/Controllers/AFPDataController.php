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
use Carbon\Carbon;
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

    function dataManagement(Request $request)
    {
        $datas = AFPData::query();
        if ($request->filled('fieldFilter')) {
            $datas->where('field', 'like', '%' . $request->fieldFilter . '%');
        }

        if ($request->filled('provinceFilter')) {
            $datas->where('province', $request->provinceFilter);
        }

        if ($request->filled('sexFilter')) {
            $datas->where('sex', $request->sexFilter);
        }

        if ($request->filled('ageFilter')) {
            // Example logic to filter by age ranges
            if ($request->ageFilter == '10') {
                $datas->whereBetween('age_in_years', [10, 20]);
            } elseif ($request->ageFilter == '20') {
                $datas->whereBetween('age_in_years', [20, 40]);
            } elseif ($request->ageFilter == '40') {
                $datas->where('age_in_years', '>=', 40);
            }
        }

        $datas = $datas->paginate(20);
        $provinces = AFPData::distinct('province')->pluck('province');
        return view('afp-data.data.table', [
            'totalDatas' => AFPData::count(),
            'datas' => $datas,
            'provinces' => $provinces,
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
        $contacts = [];
        foreach ($broadcasts as $broadcast) {
            $contacts[] = [
                // 'fname' => $broadcast->first_name ?? '', // Optional: Replace with actual column name
                // 'lname' => $broadcast->last_name ?? '',  // Optional: Replace with actual column name
                'phone_number' => $broadcast->phone,     // Required: Phone number
            ];
        }
        Constants::sendGeezSms($contacts, $content->content,);
        return redirect()->back()->with('success', 'Broadcast send successfully');
    }

    public function getAgeGroupDistribution()
    {
        $data = AFPData::select(
            \DB::raw('CASE
            WHEN age_in_years BETWEEN 0 AND 5 THEN "0-5"
            WHEN age_in_years BETWEEN 6 AND 10 THEN "6-10"
            WHEN age_in_years BETWEEN 11 AND 15 THEN "11-15"
            ELSE "16+" END as age_group'),
            \DB::raw('COUNT(*) as case_count')
        )->groupBy('age_group')->get();

        return response()->json($data);
    }

    public function getCaseTrends()
    {
        $data = AFPData::where('date_of_onset', '!=', null)->where('date_of_onset', '!=', 'Not applicable')->select(
            \DB::raw('DATE_FORMAT(STR_TO_DATE(date_of_onset, "%m/%d/%Y"), "%M") as month_name'),
            \DB::raw('COUNT(*) as case_count')
        )
            ->groupBy('month_name')
            ->orderBy(
                \DB::raw('STR_TO_DATE(CONCAT("01 ", month_name, " 2024"), "%d %M %Y")'),
                'ASC'
            )
            ->get();
        if (!$data['0']->month_name) {
            $data['0']->month_name = 'Unkown';
        }
        return response()->json($data);
    }
    public function getHistogramData()
    {
        // Fetch the data from AFPData model
        $data = AFPData::select('date_stool_collected', 'date_stool_received_in_lab')
            ->get();

        $delays = [];

        foreach ($data as $item) {
            $stoolCollected = $this->parseDate($item->date_stool_collected);
            $stoolReceivedInLab = $this->parseDate($item->date_stool_received_in_lab);

            // Calculate the delay in days
            if ($stoolCollected && $stoolReceivedInLab) {
                $delays[] = $stoolReceivedInLab->diffInDays($stoolCollected);
            }
        }

        // Group data into bins (e.g., 1 day intervals)
        $binSize = 1; // Size of each bin (1 day interval)
        $minDelay = min($delays);
        $maxDelay = 16;

        // Initialize bins
        $bins = [];

        // Populate bins with initialized values (ensure every possible bin exists)
        for ($i = $minDelay; $i <= $maxDelay; $i++) {
            $bins[$i] = 0; // Initialize all bins with 0
        }

        // Populate bins
        foreach ($delays as $delay) {
            $binIndex = floor(($delay - $minDelay) / $binSize);

            // Make sure the binIndex exists
            if (isset($bins[$binIndex])) {
                $bins[$binIndex] += 1; // Increment the bin count
            } else {
                // In case the binIndex doesn't exist, we can safely ignore or log it
                // or create the bin dynamically like:
                // $bins[$binIndex] = 1;
            }
        }

        // Prepare labels for bins
        $binLabels = array_map(function ($bin) use ($binSize) {
            return $bin * $binSize . ' - ' . ($bin + 1) * $binSize . ' days';
        }, array_keys($bins));

        return response()->json([
            'bins' => $binLabels,
            'counts' => array_values($bins),
        ]);
    }
    public function getHistogramDataForResultTime()
    {
        // Fetch data from the database (stool collected and final cell culture results date)
        $data = AFPData::whereNotNull('date_stool_sent_from_field')
            ->whereNotNull('date_final_cell_culture_results')
            ->get(['date_stool_sent_from_field', 'date_final_cell_culture_results']);

        // Calculate the delays
        $delays = [];
        foreach ($data as $row) {
            $dateCollected = Carbon::parse($row->date_stool_sent_from_field);
            $dateResult = Carbon::parse($row->date_final_cell_culture_results);

            // Calculate the difference in days
            $delay = $dateResult->diffInDays($dateCollected);
            $delays[] = $delay;
        }

        // Group delays into bins (for example, 0-5 days, 6-10 days, etc.)
        // dd(max($delays));
        $bins = range(0, max($delays), 1); // You can adjust the bin size if needed
        $counts = array_fill(0, count($bins), 0);

        // Count occurrences for each bin
        foreach ($delays as $delay) {
            foreach ($bins as $index => $bin) {
                if ($delay <= $bin) {
                    $counts[$index]++;
                    break;
                }
            }
        }

        // Return the data as JSON
        return response()->json([
            'bins' => $bins,
            'counts' => $counts
        ]);
    }

    // Helper method to safely parse dates
    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }
        try {
            return Carbon::parse($date);
        } catch (\Exception $e) {
            return null;
        }
    }
}
