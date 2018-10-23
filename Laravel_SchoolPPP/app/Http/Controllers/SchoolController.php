<?php

namespace App\Http\Controllers;

use App\School;
use App\SchoolStatistics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function index()
    {
        return view('pages/school-statistic', [
            'years' => School::years(),
            'months' => School::months(),
            'weeks' => School::weeks(),
            'schools' => School::all()
        ]);
    }

    public function add()
    {
        return view('pages/school-add');
    } 
    

    public function create(Request $request)
    {
        $request_data = $request->all();

        $school = new School();
        $validator = Validator::make($request_data, $school->rules);

        if ($validator->fails()) 
        {
            return back()->withInput()->withErrors($validator->errors());
        }

        $school->name = $request->name;
        $school->benchmark_water = 0;
        $school->benchmark_heating = 0;
        $school->benchmark_elect = 0;
        $school->save();

        return back()->with('status', true);
    }

    public function save(Request $request)
    {
        $request_data = $request->all();

        $schoolStatistics = new SchoolStatistics();
        $validator = Validator::make($request_data, $schoolStatistics->rules);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $data = [
            'school_id' => $request_data['school'],
            'year' => $request_data['year'],
            'week' => $request_data['week'],
            'month' => $request_data['month'],
            'elect_eur' => $request_data['electricity_euro'],
            'elect_kwh' => $request_data['electricity_kwh'],
            'heating_eur' => $request_data['heating_euro'],
            'heating_kwh' => $request_data['heating_kwh'],
            'water_eur' => $request_data['water_euro'],
            'water_litres' => $request_data['water_litres']
        ];

        SchoolStatistics::create($data);

        return back()->with('status', true);
    }

    public function graph($id)
    {
        return view('pages/school-graph', [
            'school_id' => $id,
            'years' => School::years(),
            'months' => School::months()
        ]);
    }

    private static function getCategories($year, $month = null)
    {
        $categories = array();
        if ($month) {
            $first_week = date('W', strtotime($year . '-' . $month . '-01'));
            $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $last_week = date('W', strtotime($year . '-' . $month . '-' . $number));

            for ($i = $first_week; $i <= $last_week; $i++) {
                if ($i < 10) {
                    $a = str_replace('0', '', $i);
                } else {
                    $a = $i;
                }
                $categories[] = 'week ' . $a;
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $m = $i < 10 ? '0' . $i : $i;
                $categories[] = date('F', strtotime($year . '-' . $m . '-01'));
            }
        }

        return $categories;
    }

    public function graphData(Request $request)
    {
        $school_id = $request->school_id;
        $year = $request->year;
        $month = $request->month;

        $school = School::where('id', $school_id)->first();

        return response()->json([
            [
                'money' => $school->chart('elect_eur', $year, $month),
                'value' => $school->chart('elect_kwh', $year, $month),
            ],
            [
                'money' => $school->chart('heating_eur', $year, $month),
                'value' => $school->chart('heating_kwh', $year, $month),
            ],
            [
                'money' => $school->chart('water_eur', $year, $month),
                'value' => $school->chart('water_litres', $year, $month),
            ]
        ]);
    }

    public function statisticsList($id)
    {
        $school = School::where('id', $id)->first();

        $data = SchoolStatistics::select('schools_statistics.*', 'schools.id as school_id')
            ->leftJoin('schools', 'schools.id', '=', 'schools_statistics.school_id')
            ->where('school_id', $id)
            ->orderBy('year')
            ->orderBy('month')
            ->orderBy('week')
            ->get();

        $school_data = [];
        foreach ($data as $item) {
            $school_data[] = [
                'id' => $item->id,
                'school_id' => $item->school_id,
                'year' => $item->year,
                'week' => $item->week,
                'month' => date('F', mktime(0, 0, 0, $item->month, 10)),
                'elect_eur' => $item->elect_eur,
                'elect_kwh' => $item->elect_kwh,
                'heating_eur' => $item->heating_eur,
                'heating_kwh' => $item->heating_kwh,
                'water_eur' => $item->water_eur,
                'water_litres' => $item->water_litres,
            ];
        }

        return view('pages/statistics-list', [
            'data' => $school_data,
            'school' => $school,
            'years' => School::years(),
            'months' => School::months(),
        ]);
    }

    public function data($id, Request $request)
    {
        $year = $request->year;
        $month = $request->month;

        $data = SchoolStatistics::select('schools_statistics.*', 'schools.id as school_id')
            ->leftJoin('schools', 'schools.id', '=', 'schools_statistics.school_id')
            ->where('school_id', $id)
            ->orderBy('year')
            ->orderBy('month')
            ->orderBy('week');

        if ($year) {
            $data->where('year', $year);
        }
        if ($month) {
            $data->where('month', $month);
        }
        $data = $data->get();

        $school_data = [];
        foreach ($data as $item) {
            $school_data[] = [
                'id' => $item->id,
                'school_id' => $item->school_id,
                'year' => $item->year,
                'week' => $item->week,
                'month' => date('F', mktime(0, 0, 0, $item->month, 10)),
                'elect_eur' => $item->elect_eur,
                'elect_kwh' => $item->elect_kwh,
                'heating_eur' => $item->heating_eur,
                'heating_kwh' => $item->heating_kwh,
                'water_eur' => $item->water_eur,
                'water_litres' => $item->water_litres,
            ];
        }

        return view('pages/statistics-list-table', ['data' => $school_data]);
    }

    public function statisticEdit($id)
    {
        $statistics = SchoolStatistics::where('id', $id)->first();

        return view('pages/school-statistic-edit', [
            'years' => School::years(),
            'months' => School::months(),
            'statistics' => $statistics,
            'weeks' => School::weeks(),
            'schools' => School::all()
        ]);
    }

    public function statisticEditSave(Request $request, $id)
    {
        $request_data = $request->all();

        $schoolStatistics = new SchoolStatistics();
        $validator = Validator::make($request_data, $schoolStatistics->rules);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $data = [
            'school_id' => $request_data['school'],
            'year' => $request_data['year'],
            'week' => $request_data['week'],
            'month' => $request_data['month'],
            'elect_eur' => $request_data['electricity_euro'],
            'elect_kwh' => $request_data['electricity_kwh'],
            'heating_eur' => $request_data['heating_euro'],
            'heating_kwh' => $request_data['heating_kwh'],
            'water_eur' => $request_data['water_euro'],
            'water_litres' => $request_data['water_litres']
        ];

        SchoolStatistics::where('id', $id)->update($data);

        return back()->with('status', true);
    }

    public function statisticDelete($id)
    {
        $school = SchoolStatistics::where('id', $id)->first();
        $school_id = $school->school_id;
        SchoolStatistics::where('id', $id)->delete();
        return redirect()->route("list", [$school_id]);
    }

    public function saveBenchmark(Request $request, $id)
    {
        switch ($request->type) {
            case 0;
                $column = 'benchmark_elect';
                break;

            case 1;
                $column = 'benchmark_heating';
                break;

            case 2;
                $column = 'benchmark_water';
                break;
        }

        School::where('id', $id)->update([$column => $request->value]);
    }

    public function download($id, Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $chart = $request->chart;

        $school = School::where('id', $id)->first();

        $school->download($chart, $year, $month);
    }
}
