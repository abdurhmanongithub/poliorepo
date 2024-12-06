<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function regionalDistribution()
    {
        $regions = [
            'area_name_zone_somali' => 'Somali',
            'area_name_zone_oromia' => 'Oromia',
            'area_name_zone_gambella' => 'Gambella',
            'area_name_zone_benshangul' => 'Benshangul',
            'area_name_zone_snnp' => 'SNNP'
        ];

        // Prepare an array to store the counts for each region
        $regionCounts = [];

        // Loop over each region and count non-null entries
        foreach ($regions as $column => $regionName) {
            $count = DB::table('core_group_data')
                ->whereNotNull($column)
                ->where($column, '!=', 'n/a')
                ->count();
            $regionCounts[] = ['region' => $regionName, 'count' => $count];
        }

        // Return the counts as JSON
        return response()->json($regionCounts);
    }
    public function afpProvinceDistribution()
    {
        $regionCounts = DB::table('a_f_p_data')
            ->select('province', DB::raw('count(*) as count'))
            ->groupBy('province')
            ->get();

        // Return the data as JSON
        return response()->json($regionCounts);
    }
    public function getPolioVirusDetectionByYear()
    {
        // Query to process and retrieve data
        $data = DB::table('polio_lab')
            ->selectRaw("YEAR(STR_TO_DATE(date_of_onset, '%m/%d/%Y')) as year, COUNT(*) as cases")
            ->where('final_cell_culture_result', 'like', '%1-Suspected Poliovirus%') // Filter for detected cases
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        $years = $data->pluck('year')->toArray(); // X-axis categories
        $cases = $data->pluck('cases')->toArray(); // Y-axis values
        $years[0] = 'Unkown';
        return response()->json([
            'categories' => $years,
            'series' => [
                [
                    'name' => 'Polio Cases Detected',
                    'data' => $cases,
                ],
            ],
        ]);
    }
}
