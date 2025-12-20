<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\StudyRecord;
use Carbon\Carbon;

class StudyRecordsChart extends Component
{

    public $chartData = [];
    public $groupBy = 'category';
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

    public function UpdatedGroupBy() {
        $this->loadChartData();
    }

    public function loadChartData() {
        // Use the strings directly in the query
        $this->chartData = StudyRecord::where('user_id', $this->userId)
            ->whereBetween('start_datetime', [$this->startDate, $this->endDate])
            ->select($this->groupBy)
            ->selectRaw('SUM(EXTRACT(EPOCH FROM (end_datetime - start_datetime))) / 3600 AS study_hours')
            ->groupBy($this->groupBy)
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->{$this->groupBy} ?? 'Uncategorized', 
                    'data' => [(float) $item->study_hours],
                    'borderWidth' => 2,
                    'barThickness' => 10,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.profile.study-records-chart');
    }
}
