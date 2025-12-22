<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyRecord;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $startDate = Carbon::parse($request->input('start'))->format('Y-m-d');
        $endDate = Carbon::parse($request->input('end'))->format('Y-m-d');
        $userId = $request->input('userId');

        $diff = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
        
        \Log::info('Diff in days: ' . $diff);
        \Log::info('userId: ' . $userId);

        if($diff > 7) {
            // 1. Get daily study hours with date
            $events = StudyRecord::where('user_id', $userId)
            ->wherebetween('start_datetime', [$startDate, $endDate])
            ->selectRaw('CAST(start_datetime AS DATE) AS start')
            ->selectRaw("ROUND(CAST(SUM(EXTRACT(EPOCH FROM (end_datetime - start_datetime))) / 3600 AS numeric), 1) || 'h' AS title")
            ->groupByRaw('CAST(start_datetime AS DATE)')
            ->get()
            ->map(function($record) {
                $record->allDay = true;
                return $record;
            });;
        } else {
            $events = StudyRecord::where('user_id', $userId)
                ->wherebetween('start_datetime', [$startDate, $endDate])
                ->selectRaw('start_datetime AS start')
                ->selectRaw('end_datetime AS end')
                ->selectRaw("ROUND(CAST(EXTRACT(EPOCH FROM (end_datetime - start_datetime)) / 3600 AS numeric), 1) || 'h' AS title")
                ->get()
                ->map(function($record) {
                    $record->allDay = false; 
                    return $record;
                });

        }





        return response()->json($events);
    }
}
