<?php
namespace App\Imports;

use App\Models\WeatherData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WeatherDataImport implements ToModel, WithHeadingRow
{
    protected $location;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function __construct($location)
    {

        $this->location = $location;
    }
    public function model(array $row)
    {
        return new WeatherData([
            'year' => $row['year'],
            'mo' => $row['mo'],
            'dy' => $row['dy'],
            't2m' => $row['t2m'],
            't2mdew' => $row['t2mdew'],
            't2mwet' => $row['t2mwet'],
            'ts' => $row['ts'],
            't2m_range' => $row['t2m_range'],
            't2m_max' => $row['t2m_max'],
            't2m_min' => $row['t2m_min'],
            'qv2m' => $row['qv2m'],
            'rh2m' => $row['rh2m'],
            'prectotcorr' => $row['prectotcorr'],
            'location' => $this->location
        ]);
    }
}
