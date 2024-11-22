<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->table($table)
            ->paginate(10, ['*'], 'page', $page);
        $columns = $columns = DB::connection('pgsql')->getSchemaBuilder()->getColumnListing($table);
        $tablesWithRowCount = [];
        return view('polio.detail', compact('table','rows','columns'));
    }
}
