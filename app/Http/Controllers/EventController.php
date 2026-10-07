<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\StudyRecord;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

/**
 * Provides study record events as JSON for the calendar.
 */
class EventController extends Controller
{
    /**
     * Return a user's study records for the requested date range.
     *
     * The shape of the response depends on the range length:
     * - More than 7 days (monthly view): one all-day event per date, with the
     *   title showing total hours studied that day (e.g. "2.5h").
     * - 7 days or fewer (weekly/daily view): one event per record, with its own
     *   start, end and duration as the title.
     *
     * Query parameters:
     * - start:  range start (date)
     * - end:    range end (date, after start)
     * - userId: owner of the study records
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'userId' => 'required|integer|exists:users,id',
        ]);

        // Get startDate, endDate and userId from request
        $startDate = Carbon::parse($validated['start'])->format('Y-m-d');
        $endDate = Carbon::parse($validated['end'])->format('Y-m-d');
        $userId = $validated['userId'];

        // Compuete date difference to find out viewType
        $diff = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));

        // Response for monthly view
        if($diff > 7) {
            // Get total study hours for each date
            $events = StudyRecord::where('user_id', $userId)
            ->wherebetween('start_datetime', [$startDate, $endDate])
            ->selectRaw('CAST(start_datetime AS DATE) AS start')
            ->selectRaw("ROUND(CAST(SUM(EXTRACT(EPOCH FROM (end_datetime - start_datetime))) / 3600 AS numeric), 1) || 'h' AS title")
            ->groupByRaw('CAST(start_datetime AS DATE)')
            ->get()
            ->map(function($record) {
                $record->allDay = true;
                return $record;
            });

        // Response for weekly/daily view
        } else {
            // Get each study hour records (Not summed up for each date)
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
