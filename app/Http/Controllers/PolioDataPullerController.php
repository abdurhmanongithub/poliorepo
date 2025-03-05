<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use stdClass;

class PolioDataPullerController extends Controller
{
    //

    public function index()
    {

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
    public function allIndex()
    {
        // $page = request()->get('page', 1);  // Get the 'clinical_page' query parameter or default to 1 if not provided
        // $table = 'demographic_by_vols';
        // // $rows = DB::connection('pgsql')
        // //     ->table($table);
        // $rows = DB::connection('pgsql')->table('clinical_histories')
        //     ->join('demographic_by_vols', 'clinical_histories.epid_number', '=', 'demographic_by_vols.epid_number')
        //     ->join('enviroment_info1s', 'clinical_histories.epid_number', '=', 'enviroment_info1s.epid_number')
        //     ->join('enviroment_infos', 'clinical_histories.epid_number', '=', 'enviroment_infos.epid_number')
        //     ->join('followup_investigations', 'clinical_histories.epid_number', '=', 'followup_investigations.epid_number')
        //     ->join('lab_stool_info1s', 'clinical_histories.epid_number', '=', 'lab_stool_info1s.epid_number')
        //     ->join('lab_stool_infos', 'clinical_histories.epid_number', '=', 'lab_stool_infos.epid_number')
        //     ->join('labaratory_info1s', 'clinical_histories.epid_number', '=', 'labaratory_info1s.epid_number')
        //     ->join('labaratory_infos', 'clinical_histories.epid_number', '=', 'labaratory_infos.epid_number')
        //     ->join('multimedia_infos', 'clinical_histories.epid_number', '=', 'multimedia_infos.epid_number')
        //     ->join('petient_demographies', 'clinical_histories.epid_number', '=', 'petient_demographies.epid_number')
        // ;
        // // $columns = $columns = DB::connection('pgsql')->getSchemaBuilder()->getColumnListing($table);

        // $tablesWithRowCount = [];
        // $fields = [];
        // $items = 0;
        // $regions = [];
        // $zones = [];
        // $woredas = [];
        // $genders = [];
        // $rows = $rows->select(
        //     'clinical_histories.*',
        //     'demographic_by_vols.*',
        //     'enviroment_info1s.*',
        //     'enviroment_infos.*',
        //     'followup_investigations.*',
        //     'lab_stool_info1s.*',
        //     'lab_stool_infos.*',
        //     'labaratory_info1s.*',
        //     'labaratory_infos.*',
        //     'multimedia_infos.*',
        //     'petient_demographies.*'
        // );
        // $rows = $rows->paginate(10, ['*'], 'page', $page);
        // $columns = $rows->isNotEmpty() ? array_keys((array) $rows->first()) : [];
        $page = request()->get('page', 1); // Get the 'page' query parameter, default to 1

        $tables = [
            'demographic_by_vols',
            'enviroment_info1s',
            'enviroment_infos',
            'followup_investigations',
            'lab_stool_info1s',
            'lab_stool_infos',
            'labaratory_info1s',
            'labaratory_infos',
            'multimedia_infos',
            'petient_demographies'
        ];
        $tablesWithRowCount = [];
        $fields = [];
        $items = 0;
        $regions = [];
        $zones = [];
        $woredas = [];
        $genders = [];
        // Start with the main table
        $query = DB::connection('pgsql')->table('clinical_histories');

        // Join all tables using epid_number
        foreach ($tables as $table) {
            $query->leftJoin($table, 'clinical_histories.epid_number', '=', "$table.epid_number");
        }

        // Select all columns
        $query->select('clinical_histories.*');
        foreach ($tables as $table) {
            $query->addSelect("$table.*");
        }

        // Paginate results
        $rows = $query->paginate(10, ['*'], 'page', $page);


        // Extract column names dynamically
        $columns = $rows->isNotEmpty() ? array_keys((array) $rows->first()) : [];

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
        return view('polio.db.index', compact('table', 'regions', 'genders', 'zones', 'woredas', 'rows', 'fields', 'columns'));
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


    public function aggregatedData(Request $request)
    {
        // Fetch table names from PostgreSQL
        $tableNames = DB::connection('pgsql')->getDoctrineSchemaManager()->listTableNames();
        $tableNames = array_slice($tableNames, 0, 11); // Limit to first 11 tables

        $mergedData = [];
        $fields = ['epid_number']; // Default column to always include
        $regions = $zones = $woredas = $genders = []; // To store unique values for filtering

        // Fetch and merge data from each table
        foreach ($tableNames as $table) {
            $rows = DB::connection('pgsql')->table($table)->select('*')->get()->toArray();
            foreach ($rows as $row) {
                $row = (array) $row; // Convert object to array
                $epidNumber = $row['epid_number'] ?? null;

                if ($epidNumber) {
                    if (!isset($mergedData[$epidNumber])) {
                        $mergedData[$epidNumber] = ['epid_number' => $epidNumber];
                    }
                    $mergedData[$epidNumber] = array_merge($mergedData[$epidNumber], $row);
                }

                // Collect all column names dynamically
                foreach (array_keys($row) as $col) {
                    if (!in_array($col, $fields)) {
                        $fields[] = $col;
                    }
                }

                // Collect unique filter values
                if (!empty($row['region']) && !in_array($row['region'], $regions)) {
                    $regions[] = $row['region'];
                }
                if (!empty($row['zone']) && !in_array($row['zone'], $zones)) {
                    $zones[] = $row['zone'];
                }
                if (!empty($row['woreda']) && !in_array($row['woreda'], $woredas)) {
                    $woredas[] = $row['woreda'];
                }
                if (!empty($row['gender']) && !in_array($row['gender'], $genders)) {
                    $genders[] = $row['gender'];
                }
            }
        }

        // Convert associative array to indexed array
        $mergedData = array_values($mergedData);

        // Apply filters
        if ($request->filled('fieldEpidNumber')) {
            $mergedData = array_filter($mergedData, function ($item) use ($request) {
                return $item['epid_number'] == $request->fieldEpidNumber;
            });
        }

        if ($request->filled('regionFilter')) {
            $mergedData = array_filter($mergedData, function ($item) use ($request) {
                return isset($item['region']) && $item['region'] == $request->regionFilter;
            });
        }

        if ($request->filled('zoneFilter')) {
            $mergedData = array_filter($mergedData, function ($item) use ($request) {
                return isset($item['zone']) && $item['zone'] == $request->zoneFilter;
            });
        }

        if ($request->filled('woredaFilter')) {
            $mergedData = array_filter($mergedData, function ($item) use ($request) {
                return isset($item['woreda']) && $item['woreda'] == $request->woredaFilter;
            });
        }

        if ($request->filled('genderFilter')) {
            $mergedData = array_filter($mergedData, function ($item) use ($request) {
                return isset($item['gender']) && $item['gender'] == $request->genderFilter;
            });
        }

        // Convert filtered results back to indexed array
        $mergedData = array_values($mergedData);

        // Manual Pagination
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $currentItems = array_slice($mergedData, ($currentPage - 1) * $perPage, $perPage);
        $paginatedData = new LengthAwarePaginator($currentItems, count($mergedData), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('polio.aggregated', [
            'fields' => $fields,
            'mergedData' => $paginatedData, // Paginated filtered results
            'regions' => $regions,
            'zones' => $zones,
            'woredas' => $woredas,
            'genders' => $genders
        ]);
    }
}
