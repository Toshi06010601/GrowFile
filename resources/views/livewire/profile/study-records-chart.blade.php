<x-section>
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
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
                            label: 'Study hours',
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

        <div class="flex flex-row justify-between mb-5">
            <select wire:model.change="groupBy" id="group-by">
                <option value="category">Category</option>
                <option value="activity">Activity</option>
            </select>
        </div>

        <nav class="flex flex-row justify-between mb-5">
            <div class="inline-flex">
                <x-tertiary-button class="rounded-l-md" wire:click="loadPrevChart">
                    <img src={{ asset('images/icons/prev.svg') }} alt="prev-icon"
                        class="w-4 cursor-pointer hover:scale-110">
                </x-tertiary-button>

                <x-tertiary-button class="rounded-r-md" wire:click="loadNextChart">
                    <img src={{ asset('images/icons/next.svg') }} alt="prev-icon"
                        class="w-4 cursor-pointer hover:scale-110">
                </x-tertiary-button>
            </div>
            <div class="inline-flex">
                @foreach (['year', 'month', 'week'] as $view)
                    <x-tertiary-button wire:click="changeViewType('{{ $view }}')"
                        class="{{ $viewType === $view ? 'bg-[#4b5563] text-white' : 'bg-[#374151] text-brand-secondary-300' }} {{ $loop->first ? 'rounded-l-md' : '' }} {{ $loop->last ? 'rounded-r-md' : '' }} hover:text-white transition font-normal">
                        {{ $view }}
                    </x-tertiary-button>
                @endforeach

            </div>
        </nav>

        <div class="w-full mb-3 text-center">
            <h3 class="text-2xl text-brand-secondary-600">
                @switch($viewType)
                    @case('year')
                        Jan - Dec {{ $startDate->format('Y') }}
                    @break

                    @case('month')
                        {{ $startDate->format('F Y') }}
                    @break

                    @default
                        @if ($startDate->isSameMonth($endDate))
                            {{ $startDate->format('M d') . ' – ' . $endDate->format('d, Y') }}
                        @else
                            {{ $startDate->format('M d, Y') . ' – ' . $endDate->format('M d, Y') }}
                        @endif
                @endswitch
            </h3>
        </div>

        <div class="relative h-[250px] w-full mb-3">
            <div class="{{ count($chartData) > 0 ? 'h-full w-full' : 'hidden' }}">
                <canvas id="study-hour-chart" wire:ignore>
                </canvas>
            </div>
            <div class="mt-12 text-center {{ count($chartData) > 0 ? 'hidden' : '' }}">
                <img src="{{ asset('images/icons/chart.svg') }}" alt="" class="h-12 w-12 mx-auto">
                <p class="mt-2 text-base text-brand-secondary-600">No data to display for this period</p>
            </div>
        </div>

        <div class="w-full text-center text-brand-secondary-600">
            <p>Total for the {{ $viewType }}: {{ number_format($totalHours, 1) }} hours</p>
        </div>

    </div>

</x-section>
