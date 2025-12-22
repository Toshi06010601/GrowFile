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
    public $currentAnchor;
    public $startDate;
    public $endDate;
    public $viewType = 'week';
    public $totalHours;

    public function mount($userId) {
        $this->userId = $userId;
        $this->currentAnchor = now()->startOfWeek();
        $this->startDate = now()->startOfWeek();
        $this->endDate = now()->endOfWeek();
        $this->loadChartData();
    }

    public function loadPrevChart() {
        $this->currentAnchor = match($this->viewType) {
            'week' => $this->currentAnchor->subWeek()->startOfWeek(),
            'month' => $this->currentAnchor->subMonth()->startOfMonth(),
            'year' => $this->currentAnchor->subYear()->startOfYear(),
        };
        $this->syncWithCurrentAnchor();
        $this->loadChartData();
    }

    public function loadNextChart() {
         $this->currentAnchor = match($this->viewType) {
            'week' => $this->currentAnchor->addWeek()->startOfWeek(),
            'month' => $this->currentAnchor->addMonth()->startOfMonth(),
            'year' => $this->currentAnchor->addYear()->startOfYear(),
        };
        $this->syncWithCurrentAnchor();
        $this->loadChartData(); 
    }
    
    public function UpdatedGroupBy() {
        $this->loadChartData();
    }
    
    public function changeViewType($viewType) {
        $this->viewType = $viewType;
        $this->currentAnchor = match($this->viewType) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
        };
        
        $this->syncWithCurrentAnchor();
        $this->loadChartData();
    }
    
    public function syncWithCurrentAnchor() {
        $this->startDate = match($this->viewType) {
            'week' => $this->currentAnchor->copy()->startOfWeek(),
            'month' => $this->currentAnchor->copy()->startOfMonth(),
            'year' => $this->currentAnchor->copy()->startOfYear(),
        };

        $this->endDate = match($this->viewType) {
            'week' => $this->currentAnchor->copy()->endOfWeek(),
            'month' => $this->currentAnchor->copy()->endOfMonth(),
            'year' => $this->currentAnchor->copy()->endOfYear(),
        };

        \Log::info('currentAnchor is ' . $this->currentAnchor);
        \Log::info('startDate is ' . $this->startDate);
        \Log::info('endDate is ' . $this->endDate);
        \Log::info('viewType is ' . $this->viewType);
    }

    public function loadChartData() {
        // Use the strings directly in the query
        $this->chartData = StudyRecord::where('user_id', $this->userId)
            ->whereBetween('start_datetime', [$this->startDate, $this->endDate])
            ->select($this->groupBy)
            ->selectRaw('SUM(EXTRACT(EPOCH FROM (end_datetime - start_datetime))) / 3600 AS study_hours')
            ->groupBy($this->groupBy)
            ->get()
            ->toArray();
        
        $this->totalHours = collect($this->chartData)->sum('study_hours');
    }

    public function render()
    {
        return view('livewire.profile.study-records-chart');
    }
}
