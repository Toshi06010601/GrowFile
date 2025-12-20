<x-section>
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-gray-900">
            Study Stats
        </h2>
    </x-slot>
    {{-- AlpineJS to initialize and update chart --}}
    <div class="flex flex-col" x-data="{
        chartData: @entangle('chartData'),
        groupBy: @entangle('groupBy'),
    
        init() {
            // 1. Initial rendering
            this.initChart();
    
            // 2. Monitor chartData change
            this.$watch('chartData', () => {
                this.updateChart();
            });
        },
    
        initChart() {
            //windowに変数を入れて Alpine/Livewire の監視対象から外す
            window.studyChart = new Chart(
                document.getElementById('study-hour-chart'), {
                    type: 'bar',
                    data: {
                        labels: ['study hours'],
                        datasets: this.chartData,
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Critical for custom container heights
                        indexAxis: 'y',
                        plugins: {
                            colors: {
                                forceOverride: true // This forces Chart.js to generate colors
                            },
                            legend: {
                                display: true,
                                position: 'bottom'
                            },
                        },
                        scales: {
                            x: {
                                stacked: true, // Enable stacking on x-axis
                               
                                beginAtZero: true,
                                grid: {
                                    display: true
                                }
                            },
                            y: {
                                stacked: true, // Enable stacking on y-axis
                                title: {
                                    display: false
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
    
                    }
                }
            );
        },
    
        updateChart() {
            const chart = window.studyChart;
    
            if (!chart) return;
    
            chart.data.datasets = this.chartData;
    
            chart.update();
    
        },
    
    }">

        <div class="flex flex-row justify-between">
            <select wire:model.change="groupBy" id="group-by">
                <option value="category">Category</option>
                <option value="activity">Activity</option>
            </select>
        </div>

        <div class="mb-5 relative h-[100px] w-full">
            <canvas id="study-hour-chart" wire:ignore></canvas>
        </div>
{{-- 
        <nav class="mb-5 px-3 flex flex-row justify-between items-center">
            <a wire:click="loadPrevChart"
                class="relative px-3 text-blue-700 cursor-pointer w-fit block after:block after:content-[''] after:absolute after:h-[2px] after:bg-green-800 after:w-2/3 after:scale-x-0 after:hover:scale-x-100 after:transition after:duration-300 after:origin-left">prev</a>
            <a wire:click="loadNextChart"
                class="relative px-3 text-blue-700 cursor-pointer w-fit block after:block after:content-[''] after:absolute after:h-[2px] after:bg-green-800 after:w-2/3 after:scale-x-0 after:hover:scale-x-100 after:transition after:duration-300 after:origin-left">next</a>
        </nav> --}}

    </div>

</x-section>
