<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class PolioDataPullerController extends Controller
{
    //

    public function index()
    {
        // $page = request()->get('clinical_page', 1);  // Get the 'clinical_page' query parameter or default to 1 if not provided

        // $clinicalHistories = DB::connection('pgsql')
        //     ->table('clinical_histories')
        //     ->paginate(10, ['*'], 'page', $page);
        // $clinicalHistoryColumns = $columns = DB::connection('pgsql')->getSchemaBuilder()->getColumnListing('clinical_histories');
        $tablesWithRowCount = [];

        $tableNames = DB::connection('pgsql')->getDoctrineSchemaManager()->listTableNames();
        $tableNames = array_slice($tableNames, 0, 11);
        foreach ($tableNames as $table) {
            $rowCount = DB::connection('pgsql')->table($table)->count();  // Get the row count for each table
            $tablesWithRowCount[] = [
                'table_name' => $table,
                'row_count'  => $rowCount
            ];
        }
        return view('polio.index', compact('tablesWithRowCount'));
    }
    public function show($table)
    {
        $page = request()->get('page', 1);  // Get the 'clinical_page' query parameter or default to 1 if not provided

        $rows = DB::connection('pgsql')
            ->table($table);
        $columns = $columns = DB::connection('pgsql')->getSchemaBuilder()->getColumnListing($table);

        $tablesWithRowCount = [];
        $fields = [];
        $items = 0;
        $regions = [];
        $zones = [];
        $woredas = [];
        $genders = [];
        // if (in_array('region', $columns)) {
        //     $regions = DB::connection('pgsql')
        //         ->table($table)->where('region', '!=', '')->distinct('region')->pluck('region');
        //     if (request()->has('regionFilter') && request('regionFilter') !== '') {
        //         $rows->where('region', request('regionFilter'));
        //     }
        // }
        // if (in_array('zone', $columns)) {
        //     $zones = DB::connection('pgsql')
        //         ->table($table)->where('zone', '!=', '')->distinct('zone')->pluck('zone');
        //     if (request()->has('zoneFilter') && request('zoneFilter') !== '') {
        //         $rows->where('zone', request('zoneFilter'));
        //     }
        // }
        // if (in_array('woreda', $columns)) {
        //     $woredas = DB::connection('pgsql')
        //         ->table($table)->where('woreda', '!=', '')->distinct('woreda')->pluck('woreda');
        //     if (request()->has('woredaFilter') && request('woredaFilter') !== '') {
        //         $rows->where('woreda', request('woredaFilter'));
        //     }
        // }

        // if (in_array('gender', $columns)) {
        //     $genders = DB::connection('pgsql')
        //         ->table($table)
        //         ->where('gender', '!=', '')
        //         ->selectRaw('DISTINCT LOWER(gender) as gender') // Standardize the case to lowercase
        //         ->pluck('gender');
        //     if (request()->has('genderFilter') && request('genderFilter') !== '') {
        //         $rows->whereRaw('LOWER(gender) = ?', [strtolower(request('genderFilter'))]);
        //     }
        // }
        // if (in_array('epid_number', $columns)) {
        //     if (request()->has('fieldEpidNumber') && request('fieldEpidNumber') !== '') {
        //         $rows->where('epid_number', 'LIKE', '%' . request('fieldEpidNumber') . '%');
        //     }
        // }
        if (in_array('region', $columns)) {
            $regions = DB::connection('pgsql')
                ->table($table)->where('region', '!=', '')->distinct('region')->pluck('region');

            // Null and empty check for regionFilter
            if (!is_null(request('regionFilter')) && request('regionFilter') !== '') {
                $rows->where('region', request('regionFilter'));
            }
        }

        if (in_array('zone', $columns)) {
            $zones = DB::connection('pgsql')
                ->table($table)->where('zone', '!=', '')->distinct('zone')->pluck('zone');

            // Null and empty check for zoneFilter
            if (!is_null(request('zoneFilter')) && request('zoneFilter') !== '') {
                $rows->where('zone', request('zoneFilter'));
            }
        }

        if (in_array('woreda', $columns)) {
            $woredas = DB::connection('pgsql')
                ->table($table)->where('woreda', '!=', '')->distinct('woreda')->pluck('woreda');

            // Null and empty check for woredaFilter
            if (!is_null(request('woredaFilter')) && request('woredaFilter') !== '') {
                $rows->where('woreda', request('woredaFilter'));
            }
        }

        if (in_array('gender', $columns)) {
            $genders = DB::connection('pgsql')
                ->table($table)
                ->where('gender', '!=', '')
                ->selectRaw('DISTINCT LOWER(gender) as gender') // Standardize the case to lowercase
                ->pluck('gender');

            // Null and empty check for genderFilter
            if (!is_null(request('genderFilter')) && request('genderFilter') !== '') {
                $rows->whereRaw('LOWER(gender) = ?', [strtolower(request('genderFilter'))]);
            }
        }

        if (in_array('epid_number', $columns)) {
            // Null and empty check for fieldEpidNumber
            if (!is_null(request('fieldEpidNumber')) && request('fieldEpidNumber') !== '') {
                $rows->where('epid_number', 'LIKE', '%' . request('fieldEpidNumber') . '%');
            }
        }

        foreach ($columns as $column) {
            $object = new stdClass();
            $object->selected = false;
            $object->name = $column;
            if ($items <= 5) {
                $items++;
                $object->selected = true;
            }
            array_push($fields, $object);
        }
        $rows = $rows->select($columns);
        // dump($columns);
        // dd($rows->get());
        $rows = $rows->paginate(10, ['*'], 'page', $page);
        return view('polio.detail', compact('table', 'regions', 'genders', 'zones', 'woredas', 'rows', 'fields', 'columns'));
    }
}
