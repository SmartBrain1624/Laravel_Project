<?php

namespace App\Http\Controllers;

use App\MessageHistory;
use App\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
	public function index()
	{
		return view('pages/message', [
			'years' => School::years(),
			'months' => School::months(),
			'schools' => School::all()
		]);
	}

	public function send(Request $request)
	{
        $request_data = $request->all();

        $validator = Validator::make($request_data, [
            'school' => 'required',
            'email' => 'required|email',
            'year' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $year = $request->year;
        $month = $request->month;
        $schoolIds = $request->school;

        $schools = School::whereIn('id', $schoolIds)->get();
        $charts = [
            'elect_eur',
            'elect_kwh',
            'heating_eur',
            'heating_kwh',
            'water_eur',
            'water_litres'
        ];
        $attachments = [];
        foreach ($schools as $school) {
            foreach ($charts as $chart) {
                $attachments[] = $school->download($chart, $year, $month);
            }
        }
        $subject = 'Utilities Graphs for ' . $year . ($month ? ' ' . date('F', mktime(0, 0, 0, $month, 1)) : '');
        School::send($request->email, $subject, $attachments);

        $history = MessageHistory::create([
            'email' => $request->email,
            'year' => $year ? $year : 0,
            'month' => $month ? $month : 0,
            'schools' => json_encode($schoolIds)
        ]);
        $historyDir = storage_path('charts/' . $history->id);
        mkdir($historyDir);
        foreach ($attachments as $attachment) {
            copy(storage_path('charts/' . $attachment), $historyDir . '/' . $attachment);
        }

        return redirect('email');
	}
}