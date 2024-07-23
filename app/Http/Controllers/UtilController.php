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
                'id' => $category->id,
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

        $initialData = $this->getCategoryData($categories->first()->id);

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

        return view('dashboard.show', compact('categories', 'categoryStats', 'totalCategories', 'totalUsers', 'totalData', 'totalSubCategories', 'datasetByCategory', 'exportTrendData', 'agriculturalInputChart', 'livestockMarketData', 'initialData', 'initialDataPerSeasons'));
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

        foreach ($category->subCategories as $subCategory) {
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
}
