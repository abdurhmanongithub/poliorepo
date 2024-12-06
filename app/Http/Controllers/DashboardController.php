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
    public function getAFPPolioVirusDataDetectionByYear()
    {
        // Query to process and retrieve data
        $data = DB::table('a_f_p_data')
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
            ->whereIn('sex', ['M', 'F'])
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
    public function getSuspectedPolioVirusResults()
    {
        // Query to get the count of cases based on final_cell_culture_result
        $data = DB::table('polio_lab')
            ->selectRaw('final_cell_culture_result, COUNT(*) as cases, sex')
            ->groupBy('final_cell_culture_result', 'sex') // Group by result and sex
            ->get();

        // Prepare data for the stacked bar chart
        $resultCategories = ['2-Negative', '3-NPENT', '1-Suspected Poliovirus']; // Categories for final_cell_culture_result
        $sexCategories = ['Male', 'Female']; // Gender categories
        $resultCounts = [
            '2-Negative' => ['Male' => 0, 'Female' => 0],
            '3-NPENT' => ['Male' => 0, 'Female' => 0],
            '1-Suspected Poliovirus' => ['Male' => 0, 'Female' => 0],
        ];

        // Map the cases to their respective categories (sex and final_cell_culture_result)
        foreach ($data as $row) {
            $result = $row->final_cell_culture_result;
            $gender = $row->sex == 'M' ? 'Male' : 'Female';
            $resultCounts[$result][$gender] = $row->cases;
        }

        // Prepare the data for the chart
        $chartData = [
            'labels' => $resultCategories, // X-axis labels: "Missing", "Negative", "WPV-polio"
            'maleData' => array_column($resultCounts, 'Male'), // Y-axis data for Male
            'femaleData' => array_column($resultCounts, 'Female'), // Y-axis data for Female
        ];

        // dd($chartData);
        // Return the data as JSON for the frontend
        return response()->json($chartData);
    }
    public function getPolioCasesByProvince()
    {
        // Query to group data by province and filter by final_cell_culture_result
        $data = DB::table('polio_lab')
            ->select('province', DB::raw('COUNT(*) as cases'))
            ->where('final_cell_culture_result', 'like', '%1-Suspected Poliovirus%') // Filter for detected polio cases
            ->groupBy('province')
            ->orderBy('cases', 'desc') // Sort provinces by the number of cases
            ->get();

        // Prepare data for the response
        $provinces = $data->pluck('province')->toArray(); // X-axis categories
        $cases = $data->pluck('cases')->toArray(); // Y-axis values
        return response()->json([
            'categories' => $provinces,
            'series' => [
                [
                    'name' => 'Polio Cases Detected',
                    'data' => $cases,
                ],
            ],
        ]);
    }
    // public function getPolioCaseTrends()
    // {
    //     $data = DB::table('polio_lab')
    //         ->selectRaw("MONTH(STR_TO_DATE(date_of_onset, '%m/%d/%Y')) as month, YEAR(STR_TO_DATE(date_of_onset, '%m/%d/%Y')) as year, COUNT(*) as cases")
    //         ->groupBy(DB::raw("month"), DB::raw("year"))
    //         ->orderBy('year', 'asc')
    //         ->orderBy('month', 'asc')
    //         ->get();

    //     return response()->json($data);
    // }
    public function getPolioCaseTrends()
    {
        $data = DB::table('polio_lab')
            ->selectRaw("MONTH(STR_TO_DATE(date_of_onset, '%m/%d/%Y')) as month, YEAR(STR_TO_DATE(date_of_onset, '%m/%d/%Y')) as year, COUNT(*) as cases")
            ->groupBy(DB::raw("year"), DB::raw("month"))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Prepare the data for the line chart
        $months = [];
        $cases = [];

        foreach ($data as $row) {
            $months[] = "{$row->year}-{$row->month}";  // Combine year and month for a timeline
            $cases[] = $row->cases;  // Get the case count
        }
        dd([
            'categories' => $months,
            'series' => [
                [
                    'name' => 'Polio Cases',
                    'data' => $cases
                ]
            ]
        ]);

        return response()->json([
            'categories' => $months,
            'series' => [
                [
                    'name' => 'Polio Cases',
                    'data' => $cases
                ]
            ]
        ]);
    }

    function getTimelinessOfReporting()
    {
        $data = DB::table('polio_lab')
            ->selectRaw("
            patients_names,
            province,
            district,
            date_of_onset,
            date_stool_collected,
            date_sent_from_field,
            DATEDIFF(STR_TO_DATE(date_stool_collected, '%m/%d/%Y'), STR_TO_DATE(date_of_onset, '%m/%d/%Y')) as collection_delay,
            DATEDIFF(STR_TO_DATE(date_sent_from_field, '%m/%d/%Y'), STR_TO_DATE(date_stool_collected, '%m/%d/%Y')) as sending_delay,
            DATEDIFF(STR_TO_DATE(date_sent_from_field, '%m/%d/%Y'), STR_TO_DATE(date_of_onset, '%m/%d/%Y')) as total_delay
        ")
            ->whereNotNull('date_of_onset')
            ->whereNotNull('date_stool_collected')
            ->whereNotNull('date_sent_from_field')
            ->get();

        return response()->json($data);
    }
    public function getPolioVirusDetectionByYearLineChart()
    {
        // Query to process and retrieve data
        $data = DB::table('polio_lab') // Replace with the correct table name
            ->selectRaw('YEAR(STR_TO_DATE(date_of_onset, "%m/%d/%Y")) as year, final_cell_culture_result, COUNT(*) as cases')
            ->whereIn('final_cell_culture_result', ['2-Negative', '3-NPENT', '1-Suspected Poliovirus']) // Filter for specific results
            ->groupBy('year', 'final_cell_culture_result')
            ->orderBy('year', 'asc')
            ->get();

        // Process the data
        $years = $data->pluck('year')->unique()->sort()->values()->toArray(); // X-axis categories (years)
        $years[0] = 'Unkown';
        $results = [
            '2-Negative' => array_fill(0, count($years), 0),
            '3-NPENT' => array_fill(0, count($years), 0),
            '1-Suspected Poliovirus' => array_fill(0, count($years), 0),
        ];

        // Fill the results array with counts for each final_cell_culture_result by year
        foreach ($data as $item) {
            $yearIndex = array_search($item->year, $years);
            $results[$item->final_cell_culture_result][$yearIndex] = $item->cases;
        }

        // Format the data for the chart
        $series = [];
        foreach ($results as $result => $cases) {
            $series[] = [
                'name' => $result, // The result type (2-Negative, 3-NPENT, 1-Suspected Poliovirus)
                'data' => $cases,
            ];
        }

        return response()->json([
            'categories' => $years,
            'series' => $series,
        ]);
    }

    public function getGroupedLocations()
    {
        $data = DB::table('core_group_data') // Replace with your actual table name
            ->selectRaw('
            gps_latitude,
            gps_longitude,
            COUNT(*) as record_count,
            GROUP_CONCAT(area_name_region SEPARATOR ", ") as regions,
            GROUP_CONCAT(area_name_village SEPARATOR ", ") as villages
        ')
            ->groupBy('gps_latitude', 'gps_longitude')
            ->get();

        return response()->json($data);
    }
}
