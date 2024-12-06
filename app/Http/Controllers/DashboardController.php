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
    public function getTopPolioEmergingSeasons()
    {
        // Map months to seasons
        $seasons = [
            'Winter/Kiremt' => [12, 1, 2], // December, January, February
            'Spring/Belg' => [3, 4, 5],  // March, April, May
            'Summer/Bega' => [6, 7, 8],  // June, July, August
            'Autumn/Tseday' => [9, 10, 11] // September, October, November
        ];

        // Query to get the count of polio cases by month
        $data = DB::table('polio_lab')
            ->selectRaw('MONTH(STR_TO_DATE(date_of_onset, "%m/%d/%Y")) as month, COUNT(*) as cases')
            ->where('final_cell_culture_result', 'like', '%1-Suspected Poliovirus%') // Filter for detected polio cases
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Group cases by seasons
        $seasonCounts = [
            'Winter/Kiremt' => 0,
            'Spring/Belg' => 0,
            'Summer/Bega' => 0,
            'Autumn/Tseday' => 0
        ];

        foreach ($data as $row) {
            $month = $row->month;
            foreach ($seasons as $season => $months) {
                if (in_array($month, $months)) {
                    $seasonCounts[$season] += $row->cases;
                    break;
                }
            }
        }

        // Prepare the data for the pie chart
        $seasonsData = [
            'labels' => array_keys($seasonCounts),
            'series' => array_values($seasonCounts),
        ];

        // Return the response
        return response()->json($seasonsData);
    }
    public function getTopPolioEmergingMonths()
    {
        // Query to get the count of polio cases by month
        $data = DB::table('polio_lab')
            ->selectRaw('MONTH(STR_TO_DATE(date_of_onset, "%m/%d/%Y")) as month, COUNT(*) as cases')
            ->where('final_cell_culture_result', 'like', '%1-Suspected Poliovirus%') // Filter for detected polio cases
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Prepare data for the pie chart
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
            'Unkown'
        ];

        // Initialize an array to store the number of cases per month
        $monthCounts = array_fill(0, 12, 0);

        // Loop through the data and map cases to respective months
        foreach ($data as $row) {
            $month = $row->month - 1; // Adjust for 0-based indexing
            $monthCounts[$month] = $row->cases;
        }
        // Prepare the data for the pie chart
        $monthCounts[12] = $monthCounts['-1'];
        unset($monthCounts['-1']);
        $chartData = [
            'labels' => $months,
            'series' => $monthCounts,
        ];
        // dd($chartData);

        // Return the response
        return response()->json($chartData);
    }
    public function getPolioVirusDistributionByGender()
    {
        // Query to get the count of polio cases by gender
        $data = DB::table('polio_lab')
            ->selectRaw('sex, COUNT(*) as cases')
            ->where('final_cell_culture_result', 'like', '%1-Suspected Poliovirus%') // Filter for positive polio cases
            ->whereIn('sex',['M','F'])
            ->groupBy('sex')
            ->get();

        // Prepare data for the pie chart
        $genders = ['Male', 'Female']; // Gender categories
        $genderCounts = [
            'Male' => 0,
            'Female' => 0,
        ];

        // Loop through the data and map cases to respective genders
        foreach ($data as $row) {
            $gender = $row->sex == 'M' ? 'Male' : 'Female';
            $genderCounts[$gender] = $row->cases;
        }

        // Prepare the response data for the pie chart
        $chartData = [
            'labels' => $genders,
            'series' => array_values($genderCounts), // Number of cases for each gender
        ];

        // Return the response
        return response()->json($chartData);
    }
}
