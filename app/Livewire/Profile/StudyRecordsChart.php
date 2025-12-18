<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\StudyRecord;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

class StudyRecordsChart extends Component
{

    public $chartData = [];
    public $userId;
    public $startDate;
    public $endDate;

    public function mount($userId) {
        $this->userId = $userId;
        $this->startDate = Carbon::today()->subDays(6);
        $this->endDate = Carbon::today()->addDays(1);

        $this->loadChartData();
    }

    public function loadPrevChart() {
        $this->startDate->subDays(7);
        $this->endDate->subDays(7);
        $this->loadChartData(); 
    }

    public function loadNextChart() {
        $this->startDate->addDays(7);
        $this->endDate->addDays(7);
        $this->loadChartData(); 
    }

    public function loadChartData() {
        // 1. Get daily study hours with date
        $rawData = StudyRecord::where('user_id', $this->userId)
        ->wherebetween('start_datetime', [$this->startDate, $this->endDate])
        ->selectRaw('CAST(start_datetime AS DATE) AS study_date')
        ->selectRaw('SUM(EXTRACT(EPOCH FROM (end_datetime - start_datetime))) / 3600 AS study_hours')
        ->groupByRaw('CAST(start_datetime AS DATE)')
        ->get();
        
        // 2. Make array of 7 days
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($this->startDate, $interval ,$this->endDate);
        $dates = collect($daterange)->map(function (\Datetime $date) { return $date->format('Y-m-d'); });

        // 3. Assign daily study hours to each date
        $this->chartData = $dates->map(function ($date) use($rawData) {
            // 3.1 Get the study hours for the current date
            $studyRecord = $rawData->firstWhere('study_date', $date);
            // 3.2 Return array of study date and study hours (Return 0 hours if not found)
            return [
                'study_date' => $date,
                'study_hours' => optional($studyRecord)->study_hours ?? 0,
            ];
        });

    }

    public function render()
    {
        return view('livewire.profile.study-records-chart');
    }
}
