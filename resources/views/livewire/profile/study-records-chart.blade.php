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
                    type: 'bar',
                    data: {
                        labels: this.chartData.map(row => row.study_date),
                        datasets: [{
                            label: 'Study hours per day',
                            data: this.chartData.map(row => row.study_hours)
                        }]
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

        <div class="w-full px-3">
            <canvas id="study-hour-chart" wire:ignore>
            </canvas>
        </div>

        <nav class="flex flex-row justify-between">
            <a wire:click="loadPrevChart">prev</a>
            <a wire:click="loadNextChart">next</a>
        </nav>

    </div>

</x-section>