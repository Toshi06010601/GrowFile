<x-section>
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-gray-900">
            Chart
        </h2>
    </x-slot>
    <div class="flex flex-col" x-data="{
        chartData: @entangle('chartData'),

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
                        labels: this.chartData.map(row => row.study_date),
                        datasets: [{
                            label: 'Study hours per day',
                            data: this.chartData.map(row => row.study_hours),
                            backgroundColor: 'rgba(22, 163, 74, 0.5)',
                            borderColor: 'rgba(22, 163, 74, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Critical for custom container heights
                    }
                }
            );
        },

        updateChart() {
            const chart = window.studyChart;

            if(!chart) return;

            chart.data.labels = this.chartData.map(row => row.study_date);
            chart.data.datasets[0].data = this.chartData.map(row => row.study_hours);

            chart.update();

        },

    }">

        <div class="relative h-[250px] w-full">
            <canvas id="study-hour-chart" wire:ignore>
            </canvas>
        </div>

        <nav class="my-5 px-3 flex flex-row justify-between">
            <a wire:click="loadPrevChart" class="relative text-green-700 cursor-pointer w-fit block after:block after:content-[''] after:absolute after:h-[2px] after:bg-green-800 after:w-full after:scale-x-0 after:hover:scale-x-100 after:transition after:duration-300 after:origin-left">Prev</a>
            <a wire:click="loadNextChart" class="relative text-green-700 cursor-pointer w-fit block after:block after:content-[''] after:absolute after:h-[2px] after:bg-green-800 after:w-full after:scale-x-0 after:hover:scale-x-100 after:transition after:duration-300 after:origin-left">Next</a>
        </nav>

    </div>

</x-section>