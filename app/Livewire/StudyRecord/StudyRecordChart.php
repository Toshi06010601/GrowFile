<?php

namespace App\Livewire\StudyRecord;

use Livewire\Component;
use App\Models\StudyRecord;
use Carbon\Carbon;

class StudyRecordChart extends Component
{
    // Public variables for Chart
    public $userId;
    public $chartData = [];
    public $groupBy = 'category';
    public $viewType = 'week';
    public $currentAnchor;
    public $startDate;
    public $endDate;
    public $totalHours;

    // Initialize chart
    public function mount($userId) {
        $this->userId = $userId;
        $this->currentAnchor = now()->startOfWeek();
        $this->startDate = now()->startOfWeek();
        $this->endDate = now()->endOfWeek();
        $this->loadChartData();
    }

    // Move to previous week/month/year
    public function loadPrevChart() {
        // 1. Subtract week/month/year from currentAnchor
        $this->currentAnchor = match($this->viewType) {
            'week' => $this->currentAnchor->subWeek()->startOfWeek(),
            'month' => $this->currentAnchor->subMonth()->startOfMonth(),
            'year' => $this->currentAnchor->subYear()->startOfYear(),
        };
        // 2. Sync startDate & endDate with currentAnchor
        $this->syncWithCurrentAnchor();
        
        // 3. Update chart data
        $this->loadChartData();
    }
    
    // Move to next week/month/year
    public function loadNextChart() {
        // 1. Add week/month/year from currentAnchor
        $this->currentAnchor = match($this->viewType) {
            'week' => $this->currentAnchor->addWeek()->startOfWeek(),
            'month' => $this->currentAnchor->addMonth()->startOfMonth(),
            'year' => $this->currentAnchor->addYear()->startOfYear(),
        };
        // 2. Sync startDate & endDate with currentAnchor
        $this->syncWithCurrentAnchor();
        // 3. Update chart data
        $this->loadChartData(); 
    }
    
    // Trigger when groupBy value changes
    public function UpdatedGroupBy() {
        // Update chart data with new groupby value
        $this->loadChartData();
    }
    
    // Trigger when viewType changes
    public function changeViewType($viewType) {
        // 1. Update public variable viewType
        $this->viewType = $viewType;

        // 2. reset currentAnchor depending on the viewType
        $this->currentAnchor = match($this->viewType) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
        };
        
        // 3. Sync startdate & endDate with currentAnchor
        $this->syncWithCurrentAnchor();

        // 4. Update chart data
        $this->loadChartData();
    }
    
    // Sync startDate and endDate with currentAnchor change
    public function syncWithCurrentAnchor() {
        // 1. Update startDate
        $this->startDate = match($this->viewType) {
            'week' => $this->currentAnchor->copy()->startOfWeek(),
            'month' => $this->currentAnchor->copy()->startOfMonth(),
            'year' => $this->currentAnchor->copy()->startOfYear(),
        };
        // 2. Update endDate
        $this->endDate = match($this->viewType) {
            'week' => $this->currentAnchor->copy()->endOfWeek(),
            'month' => $this->currentAnchor->copy()->endOfMonth(),
            'year' => $this->currentAnchor->copy()->endOfYear(),
        };

        logger()->info('currentAnchor is ' . $this->currentAnchor);
        logger()->info('startDate is ' . $this->startDate);
        logger()->info('endDate is ' . $this->endDate);
        logger()->info('viewType is ' . $this->viewType);
    }

    public function loadChartData() {
        // Retrieve study hours of each category or activity
        $this->chartData = StudyRecord::where('user_id', $this->userId) // Get the records for the selected user
            ->whereBetween('start_datetime', [$this->startDate, $this->endDate]) // Between the current startDate and endDate
            ->select($this->groupBy) // Select either Category or Activity column
            ->selectRaw('SUM(EXTRACT(EPOCH FROM (end_datetime - start_datetime))) / 3600 AS study_hours') // Get sum of study hours of each category or activity
            ->groupBy($this->groupBy) // GroupBy category or activity
            ->get()
            ->toArray(); // Convert to array
        
        // Get sum of all study hours within the period
        $this->totalHours = collect($this->chartData)->sum('study_hours');
    }

    public function render()
    {
        return view('livewire.study-record.chart');
    }
}
