<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Data;
use App\Models\SubCategory;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UtilController extends Controller
{
    //
    public function dashboard()
    {
        $categories = Category::with('subCategories.dataSchemas.datas')->get();
        $totalUsers = User::count();
        $totalData = Data::count();
        $totalCategories = Category::count();
        $totalSubCategories = SubCategory::count();
        $categoryStats = [];
        foreach ($categories as $category) {
            array_push($categoryStats, [
                'id' => $category?->id,
                'name' => $category->name,
                'sub_category_count' => $category->subCategories()->count(),
                'schema_count' => $category->dataSchema?->count() ?? 0,
                'data_count' => $category->getDataCount(),
                'missing_values' => 0,
            ]);
        }

        $categoryNames = [];
        $categoryDataCounts = [];

        foreach ($categories as $category) {
            $categoryNames[] = $category->name;
            $dataCount = 0;
            foreach ($category->subCategories as $subCategory) {
                foreach ($subCategory->dataSchemas as $dataSchema) {
                    if ($dataSchema->datas) {
                        $dataCount += $dataSchema->datas->count();
                    }
                }
            }
            $categoryDataCounts[] = $dataCount;
        }

        $datasetByCategory = (new LarapexChart)->pieChart()
            ->setTitle('Datasets by Category')
            ->addData($categoryDataCounts)
            ->setLabels($categoryNames)
            ->setColors(['#004c6d', '#287a8e', '#55b4b0', '#8bde97', '#b6fb80']);

        $exportTrendData = $this->getExportTrendData($categories->first()->id);

        $chart = (new LarapexChart)->lineChart()
            ->setTitle('ECG-Like Chart') // Optional: Set the chart title
            ->setSubtitle('An example of a stacked line chart') // Optional: Set the chart subtitle
            ->setColors(['#FF1654', '#247BA0', '#70C1B3', '#FF6B6B']) // Customize colors
            ->addData('Signal 1', [10, 40, 15, 30, 50, 35, 60, 20, 70]) // Replace with your data
            ->addData('Signal 2', [20, 60, 25, 20, 40, 30, 50, 40, 80]) // Replace with your data
            ->addData('Signal 3', [30, 50, 35, 10, 30, 25, 40, 30, 60]) // Replace with your data
            ->setMarkers(['#FF1654', '#247BA0', '#70C1B3']) // Markers on the line
            ->setStroke(2) // Adjust stroke width for a sharper line
            ->setXAxis(['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9']) // X-Axis labels
            // ->setGrid(true, 1, '#e0e0e0') // Add grid lines
            ->setHorizontal(true); // Make it horizontally stacked

        // dd($exportTrendData);


        // $exportTrendData = [
        //     'series' => [
        //         ['name' => 'Coffee', 'data' => [20, 24, 26, 51, 23, 32, 48, 57]],
        //         ['name' => 'Sesame', 'data' => [19, 18, 16, 29, 38, 36, 22, 9]],
        //         ['name' => 'Teff', 'data' => [16, 18, 18, 20, 29, 20, 17, 22]],
        //     ],
        //     'xAxis' => ['2013 Q1', '2013 Q2', '2013 Q3', '2013 Q4', '2014 Q1', '2014 Q2', '2014 Q3', '2014 Q4'],
        //     'colors' => ['#004c6d', '#55b4b0', '#b6fb80']
        // ];

        $initialData = $this->getCategoryData($categories->first()?->id);

        $initialDataPerSeasons = $this->getCategoryDataasSeasons($categories->first()->id);

        $agriculturalInputChart = (new LarapexChart)->pieChart()
            ->setTitle('Agricultural Input Distribution Chart')
            ->addData($initialData['series'])
            ->setLabels($initialData['labels'])
            ->setColors($initialData['colors']);

        // $agriculturalInputData = [
        //     'series' => [22.5, 30.6, 22.8, 24.1],
        //     'labels' => ['Fertilizer', 'Seeds', 'Pesticide', 'Mechanization'],
        //     'colors' => ['#004c6d', '#55b4b0', '#b6fb80', '#d4fcbc']
        // ];

        $livestockMarketData = [
            'domestic' => [23, 35, 27, 22, 17, 31, 22, 12, 16],
            'exported' => [42, 35, 43, 22, 17, 31, 22, 12, 16],
            'xAxis' => ['Jan 01', '03 Jan', '05 Jan', '07 Jan', '09 Jan', '11 Jan']
        ];

        return view('dashboard.show', compact('categories', 'categoryStats', 'totalCategories', 'totalUsers', 'totalData', 'totalSubCategories', 'datasetByCategory', 'exportTrendData', 'agriculturalInputChart', 'livestockMarketData', 'initialData', 'initialDataPerSeasons', 'chart'));
    }

    public function getSubCategoriesData(Request $request)
    {
        $categoryId = $request->input('category_id');
        $data = $this->getCategoryData($categoryId);

        return response()->json($data);
    }

    private function getCategoryData($categoryId)
    {
        $category = Category::with('subCategories.dataSchemas.datas')->find($categoryId);
        $labels = [];
        $dataCounts = [];

        foreach ($category?->subCategories ?? [] as $subCategory) {
            $labels[] = $subCategory->name;
            $dataCount = 0;
            foreach ($subCategory->dataSchemas as $dataSchema) {
                if ($dataSchema->datas) {
                    $dataCount += $dataSchema->datas->count();
                }
            }
            $dataCounts[] = $dataCount;
        }

        return [
            'series' => $dataCounts,
            'labels' => $labels,
            'colors' => ['#004c6d', '#55b4b0', '#b6fb80', '#d4fcbc'] // Adjust as necessary
        ];
    }


    public function getSubCategoriesExportTrendData(Request $request)
    {
        $categoryId = $request->input('category_id');
        $data = $this->getCategoryData($categoryId);

        return response()->json([
            'categoryData' => $data,
            'exportTrendData' => $this->getExportTrendData($categoryId)
        ]);
    }

    private function getExportTrendData($categoryId)
    {
        $category = Category::with('subCategories.dataSchemas.datas')->find($categoryId);
        $provinces = [];
        $dates = [];

        foreach ($category->subCategories as $subCategory) {
            foreach ($subCategory->dataSchemas as $dataSchema) {
                foreach ($dataSchema->datas as $data) {
                    $values = json_decode(json_encode($data->values), true);
                    $province = $values['province'] ?? 'Unknown';
                    if (!array_key_exists('date_stool_collected', $values)) {
                        continue;
                    }
                    $date = isset($values['date_stool_collected']) ? $this->getQuarter($values['date_stool_collected']) : 'Unknown';

                    if (!isset($provinces[$province])) {
                        $provinces[$province] = [];
                    }
                    if (!isset($provinces[$province][$date])) {
                        $provinces[$province][$date] = 0;
                    }
                    $provinces[$province][$date]++;
                    if (!in_array($date, $dates)) {
                        $dates[] = $date;
                    }
                }
            }
        }

        sort($dates);

        $series = [];
        foreach ($provinces as $province => $data) {
            $provinceData = [];
            foreach ($dates as $date) {
                $provinceData[] = $data[$date] ?? 0;
            }
            $series[] = ['name' => $province, 'data' => $provinceData];
        }

        return [
            'series' => $series,
            'xAxis' => $dates,
            'colors' => ['#004c6d', '#55b4b0', '#b6fb80']
        ];
    }

    private function getQuarter($date)
    {
        $date = $this->excelDateToCarbon($date);
        $timestamp = strtotime($date);
        $month = date('n', $timestamp);
        $year = date('Y', $timestamp);

        if ($month <= 3) {
            return "$year Q1";
        } elseif ($month <= 6) {
            return "$year Q2";
        } elseif ($month <= 9) {
            return "$year Q3";
        } else {
            return "$year Q4";
        }
    }

    function excelDateToCarbon($serialDate)
    {
        // Excel's epoch starts at 1900-01-01
        $baseDate = Carbon::createFromDate(1900, 1, 1);

        // Add the number of days (subtract 1 because 1900-01-01 is serial number 1)
        return $baseDate->addDays($serialDate - 1);
    }

    public function getSeasonChartData(Request $request)
    {
        $categoryId = $request->input('category_id');
        $data = $this->getCategoryDataasSeasons($categoryId);

        // dd($data);
        return [
            'series' => $data['series'],
            'labels' => $data['labels'],
            'colors' => $data['colors'],
            'quarterData' => $data['quarterData'],
            'categoryData' => $data,
        ];
    }

    private function getCategoryDataasSeasons($categoryId)
    {
        // dd('sasas');
        $category = Category::with('subCategories.dataSchemas.datas')->find($categoryId);
        $labels = [];
        $dataCounts = [];
        $quarterData = [
            'Fall' => 0,
            'Summer' => 0,
            'Spring' => 0,
            'Winter' => 0
        ];

        foreach ($category->subCategories as $subCategory) {
            $labels[] = $subCategory->name;
            $dataCount = 0;
            foreach ($subCategory->dataSchemas as $dataSchema) {
                foreach ($dataSchema->datas as $data) {
                    $values = json_decode(json_encode($data->values), true);
                    if (!array_key_exists('date_stool_collected', $values)) {
                        continue;
                    }
                    $date = \Carbon\Carbon::parse($this->excelDateToCarbon($values['date_stool_collected']));
                    $month = $date->month;

                    if ($month >= 1 && $month <= 3) {
                        $quarterData['Winter'] += 1;
                    } elseif ($month >= 4 && $month <= 6) {
                        $quarterData['Spring'] += 1;
                    } elseif ($month >= 7 && $month <= 9) {
                        $quarterData['Summer'] += 1;
                    } elseif ($month >= 10 && $month <= 12) {
                        $quarterData['Fall'] += 1;
                    }

                    $dataCount += 1;
                }
            }
            $dataCounts[] = $dataCount;
        }

        $totalData = array_sum($quarterData);
        $quarterPercentages = array_values(array_map(function ($count) use ($totalData) {
            return $totalData > 0 ? ($count / $totalData) * 100 : 0;
        }, $quarterData));

        return [
            'series' => $dataCounts,
            'labels' => $labels,
            'colors' => ['#00008B', '#FF0000', '#006400', '#FF8C00'],
            'quarterData' => $quarterPercentages,
        ];
    }

    public function fetchCoordinates($categoryId)
    {
        // Fetch the category with related data
        $category = Category::with('subCategories.dataSchemas.datas')->find($categoryId);

        if (!$category) {
            return response()->json([], 404); // Category not found
        }

        // Collect GPS coordinates
        $coordinates = [];

        foreach ($category->subCategories as $subCategory) {
            foreach ($subCategory->dataSchemas as $dataSchema) {
                foreach ($dataSchema->datas as $data) {
                    $values = json_decode(json_encode($data->values), true);
                    if (isset($values['area_name_gps_latitude']) && isset($values['area_name_gps_longitude'])) {
                        $coordinates[] = [
                            'latitude' => $values['area_name_gps_latitude'],
                            'longitude' => $values['area_name_gps_longitude']
                        ];
                    }
                }
            }
        }


        // Merge and count data from the same place
        $mergedCoordinates = [];
        foreach ($coordinates as $coordinate) {
            $key = $coordinate['latitude'] . '-' . $coordinate['longitude'];
            if (!isset($mergedCoordinates[$key])) {
                $mergedCoordinates[$key] = ['count' => 0, 'position' => $coordinate];
            }
            $mergedCoordinates[$key]['count']++;
        }

        return response()->json(array_values($mergedCoordinates));
    }

    public function getCategoryDataLineChart(Request $request)
    {
        $categoryId = $request->input('category_id');
        $category = Category::with('subCategories.dataSchemas.datas')->find($categoryId);

        $dateOfOnsetCounts = [];
        $dateStoolCollectedCounts = [];
        $dateStoolSentFromFieldCounts = [];

        foreach ($category->subCategories as $subCategory) {
            foreach ($subCategory->dataSchemas as $dataSchema) {
                foreach ($dataSchema->datas as $data) {
                    $values = $data->values;
                    $dateKeys = [
                        'date_of_onset' => &$dateOfOnsetCounts,
                        'date_stool_collected' => &$dateStoolCollectedCounts,
                        'date_stool_sent_from_field' => &$dateStoolSentFromFieldCounts
                    ];

                    foreach ($dateKeys as $key => &$counts) {
                        if (isset($values[$key])) {
                            if (!is_numeric($values[$key])) {
                                continue;
                            }
                            $date = \Carbon\Carbon::parse($this->excelDateToCarbon($values[$key]));
                            // $date = Carbon::parse("1899-12-30")->addDays($values[$key]); // Convert Excel date to normal date
                            $year = $date->year;
                            if (isset($counts[$year])) {
                                $counts[$year]++;
                            } else {
                                $counts[$year] = 1;
                            }
                        }
                    }
                }
            }
        }


        if (!empty($dateOfOnsetCounts) || !empty($dateStoolCollectedCounts) || !empty($dateStoolSentFromFieldCounts)) {
            $chart = $this->createLineChart([], $dateOfOnsetCounts, $dateStoolCollectedCounts, $dateStoolSentFromFieldCounts);
            return response()->json(['chart' => $chart]);
        }

        return response()->json(['chart' => null]);
    }

    private function createLineChart($dates, $dateOfOnsetCounts, $dateStoolCollectedCounts, $dateStoolSentFromFieldCounts)
    {
        ksort($dateOfOnsetCounts);
        ksort($dateStoolCollectedCounts);
        ksort($dateStoolSentFromFieldCounts);

        return [
            'chart' => [
                'type' => 'line',
                'height' => 400
            ],
            'title' => [
                'text' => 'Timeliness of reporting and investigation',
                'align' => 'center'
            ],
            // 'subtitle' => [
            //     'text' => 'Yearly Data Analysis'
            // ],
            'colors' => ['#FF1654', '#247BA0', '#70C1B3'],
            'series' => [
                ['name' => 'Date of Onset', 'data' => array_values($dateOfOnsetCounts)],
                ['name' => 'Date Stool Collected', 'data' => array_values($dateStoolCollectedCounts)],
                ['name' => 'Date Stool Sent From Field', 'data' => array_values($dateStoolSentFromFieldCounts)],
            ],
            'xaxis' => [
                'categories' => array_keys($dateOfOnsetCounts)
            ],
            'markers' => [
                'size' => 4,
                'colors' => ['#FF1654', '#247BA0', '#70C1B3']
            ],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 2
            ],
            'grid' => [
                'borderColor' => '#e0e0e0'
            ]
        ];
    }

    public function getCategoryDataBarChart(Request $request)
    {
        $categoryId = $request->input('category_id');
        $category = Category::with('subCategories.dataSchemas.datas')->find($categoryId);

        $results = [];
        foreach ($category->subCategories as $subCategory) {
            foreach ($subCategory->dataSchemas as $dataSchema) {
                foreach ($dataSchema->datas as $data) {
                    $values = $data->values;
                    if (isset($values['final_cell_culture_result'])) {
                        $result = $values['final_cell_culture_result'];
                        if (isset($results[$result])) {
                            $results[$result]++;
                        } else {
                            $results[$result] = 1;
                        }
                    }
                }
            }
        }


        if (!empty($results)) {
            $chart = $this->createBarChart($results);
            return response()->json(['barChart' => $chart]);
        }

        return response()->json(['barChart' => null]);
    }

    private function createBarChart($results)
    {
        ksort($results); // Optional: sort results by key
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 400
            ],
            'title' => [
                'text' => 'Distribution of Final Cell Culture Results',
                'align' => 'center'
            ],
            // 'subtitle' => [
            //     'text' => 'Distribution of Final Cell Culture Results'
            // ],
            'colors' => ['#247BA0'],
            'series' => [
                ['name' => 'Results Count', 'data' => array_values($results)]
            ],
            'xaxis' => [
                'categories' => array_keys($results)
            ],
            'grid' => [
                'borderColor' => '#e0e0e0'
            ]
        ];
    }



    // public function getCategoryDataLineChart(Request $request)
    // {
    //     $categoryId = $request->input('category_id');
    //     $category = Category::with('subCategories.dataSchemas.datas')->find($categoryId);

    //     $dates = [];
    //     foreach ($category->subCategories as $subCategory) {
    //         foreach ($subCategory->dataSchemas as $dataSchema) {
    //             foreach ($dataSchema->datas as $data) {
    //                 $values = $data->values;
    //                 $dateKeys = ['date_of_onset', 'date_stool_collected', 'date_stool_sent_from_field'];

    //                 foreach ($dateKeys as $key) {
    //                     if (isset($values[$key])) {
    //                         $date = Carbon::parse("1899-12-30")->addDays($values[$key]); // Convert Excel date to normal date
    //                         $dates[] = $date->year;
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     if (!empty($dates)) {
    //         $chart = $this->createLineChart($dates);
    //         return response()->json(['chart' => $chart->toJson()]);
    //     }

    //     return response()->json(['chart' => null]);
    // }

    // private function createLineChart($dates)
    // {
    //     $dateCounts = array_count_values($dates);
    //     ksort($dateCounts);

    //     return (new \ArielMejiaDev\LarapexCharts\LarapexChart)->lineChart()
    //         ->setTitle('Yearly Data Analysis')
    //         ->addData('Data Points', array_values($dateCounts))
    //         ->setXAxis(array_keys($dateCounts));
    // }
}
