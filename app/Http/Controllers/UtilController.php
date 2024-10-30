<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Data;
use App\Models\SubCategory;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
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

        $exportTrendData = [
            'series' => [
                ['name' => 'Coffee', 'data' => [20, 24, 26, 51, 23, 32, 48, 57]],
                ['name' => 'Sesame', 'data' => [19, 18, 16, 29, 38, 36, 22, 9]],
                ['name' => 'Teff', 'data' => [16, 18, 18, 20, 29, 20, 17, 22]],
            ],
            'xAxis' => ['2013 Q1', '2013 Q2', '2013 Q3', '2013 Q4', '2014 Q1', '2014 Q2', '2014 Q3', '2014 Q4'],
            'colors' => ['#004c6d', '#55b4b0', '#b6fb80']
        ];

        $initialData = $this->getCategoryData($categories->first()?->id);

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

        return view('dashboard.show', compact('categories', 'categoryStats', 'totalCategories', 'totalUsers', 'totalData', 'totalSubCategories', 'datasetByCategory', 'exportTrendData', 'agriculturalInputChart', 'livestockMarketData', 'initialData'));
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
}
