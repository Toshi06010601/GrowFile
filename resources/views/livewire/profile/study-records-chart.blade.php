<x-section>
    {{-- Header --}}
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            Statistics
        </h2>
    </x-slot>

    {{-- configure chartJS --}}
    <div class="flex flex-col" x-data="{
        chartData: @entangle('chartData'),
        groupBy: @entangle('groupBy'),
    
        init() {
            // 1. Initial rendering
            this.initChart();
    
            // 2. Monitor chartData change and trigger updateChart method
            this.$watch('chartData', () => {
                this.updateChart();
            });
        },
    
        initChart() {
            //Set chartObject to window to avoid monitor from Alpine/Livewire
            window.studyChart = new Chart(
                document.getElementById('study-hour-chart'), {
                    type: 'doughnut',
                    data: {
                        labels: this.chartData.map(row => row[this.groupBy]), //Group by category or activity
                        datasets: [{
                            label: 'Study hours',
                            data: this.chartData.map(row => row.study_hours), //Study hours
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Critical for custom container heights
                        plugins: {
                            colors: {
                                forceOverride: true // Forces Chart.js to generate colors automatically
                            },
                            legend: { // Categories/activities name and color relationship
                                display: true,
                                position: 'bottom'
                            },
                        },
                    }
                }
            );
        },
    
        // update groupBy and studyHours
        updateChart() {
            const chart = window.studyChart;
    
            if (!chart) return;
    
            chart.data.labels = this.chartData.map(row => row[this.groupBy]);
            chart.data.datasets[0].data = this.chartData.map(row => row.study_hours);
    
            chart.update();
    
        },
    
    }">

        {{-- GroupBy selectbox --}}
        <div class="flex flex-row justify-between mb-5">
            <select wire:model.change="groupBy" id="group-by">
                <option value="category">Category</option>
                <option value="activity">Activity</option>
            </select>
        </div>

        {{-- Navigation buttons --}}
        <nav class="flex flex-row justify-between mb-5">
            <div class="inline-flex">
                {{-- Prev button --}}
                <x-tertiary-button class="rounded-l-md" wire:click="loadPrevChart">
                    <img src={{ asset('images/icons/prev.svg') }} alt="prev-icon"
                        class="w-4 cursor-pointer hover:scale-110">
                </x-tertiary-button>

                {{-- Next button --}}
                <x-tertiary-button class="rounded-r-md" wire:click="loadNextChart">
                    <img src={{ asset('images/icons/next.svg') }} alt="prev-icon"
                        class="w-4 cursor-pointer hover:scale-110">
                </x-tertiary-button>
            </div>

            <div class="inline-flex">
                {{-- Year/Month/Week view buttons --}}
                @foreach (['year', 'month', 'week'] as $view)
                    <x-tertiary-button wire:click="changeViewType('{{ $view }}')"
                        class="{{ $viewType === $view ? 'bg-[#4b5563] text-white' : 'bg-[#374151] text-brand-secondary-300' }} {{ $loop->first ? 'rounded-l-md' : '' }} {{ $loop->last ? 'rounded-r-md' : '' }} hover:text-white transition font-normal">
                        {{ $view }}
                    </x-tertiary-button>
                @endforeach

            </div>
        </nav>

        {{-- Title --}}
        <div class="w-full mb-3 text-center">
            <h3 class="text-2xl text-brand-secondary-600">
                {{-- Change the date format depending on view type --}}
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

        {{-- Chart display area --}}
        <div class="relative h-[250px] w-full mb-3">
            {{-- Display if any chartdata exists --}}
            <div class="{{ count($chartData) > 0 ? 'h-full w-full' : 'hidden' }}">
                <canvas id="study-hour-chart" wire:ignore>
                </canvas>
            </div>
            {{-- Display if no chartdata exists --}}
            <div class="mt-12 text-center {{ count($chartData) > 0 ? 'hidden' : '' }}">
                <img src="{{ asset('images/icons/chart.svg') }}" alt="" class="h-12 w-12 mx-auto">
                <p class="mt-2 text-base text-brand-secondary-600">No data to display for this period</p>
            </div>
        </div>

        {{-- Show total study hours --}}
        <div class="w-full text-center text-brand-secondary-600">
            <p>Total for the {{ $viewType }}: {{ number_format($totalHours, 1) }} hours</p>
        </div>

    </div>

</x-section>
