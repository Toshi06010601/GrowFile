<x-section>
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-gray-900">
            Statistics
        </h2>
    </x-slot>
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
                    type: 'doughnut',
                    data: {
                        labels: this.chartData.map(row => row[this.groupBy]),
                        datasets: [{
                            label: 'Study hours per day',
                            data: this.chartData.map(row => row.study_hours),
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Critical for custom container heights
                        plugins: {
                            colors: {
                                forceOverride: true // This forces Chart.js to generate colors
                            },
                            legend: {
                                display: true,
                                position: 'bottom'
                            },
                        },
                    }
                }
            );
        },
    
        updateChart() {
            const chart = window.studyChart;
    
            if (!chart) return;
    
            chart.data.labels = this.chartData.map(row => row[this.groupBy]);
            chart.data.datasets[0].data = this.chartData.map(row => row.study_hours);
    
            chart.update();
    
        },
    
    }">

        <div class="flex flex-row justify-between">
            <select wire:model.change="groupBy" id="group-by">
                <option value="category">Category</option>
                <option value="activity">Activity</option>
            </select>
        </div>

        <nav class="flex flex-row justify-between">
            <div class="inline-flex my-5">
                <x-tertiary-button class="rounded-l-md" wire:click="loadPrevChart">
                    <img src={{ asset('images/icons/prev.svg') }} alt="prev-icon"
                        class="w-4 cursor-pointer hover:scale-110">
                </x-tertiary-button>

                <x-tertiary-button class="rounded-r-md" wire:click="loadNextChart">
                    <img src={{ asset('images/icons/next.svg') }} alt="prev-icon"
                        class="w-4 cursor-pointer hover:scale-110">
                </x-tertiary-button>
            </div>
            <div>
                <p>{{ $startDate }} - {{ $endDate }}</p>
            </div>
            <div class="inline-flex my-5">
                @foreach (['year', 'month', 'week'] as $view)
                    <x-tertiary-button wire:click="changeViewType('{{ $view }}')"
                        class="{{ $viewType === $view ? 'bg-[#4b5563] text-white' : 'bg-[#374151] text-gray-300' }} {{ $loop->first ? 'rounded-l-lg' : '' }} {{ $loop->last ? 'rounded-r-lg' : '' }} hover:text-white transition font-normal">
                        {{ $view }}
                    </x-tertiary-button>
                @endforeach

            </div>

        </nav>

        <div class="relative h-[250px] w-full">
            <canvas id="study-hour-chart" wire:ignore>
            </canvas>
        </div>

    </div>

</x-section>
