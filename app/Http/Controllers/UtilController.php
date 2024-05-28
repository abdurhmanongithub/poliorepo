<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Data;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;

class UtilController extends Controller
{
    //
    public function dashboard()
    {
        $categories = Category::all();
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
        return view('dashboard.show', compact('categories', 'categoryStats', 'totalCategories', 'totalUsers', 'totalData', 'totalSubCategories'));
    }
}
