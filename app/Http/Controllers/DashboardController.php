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
}
