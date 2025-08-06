<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-900 dark:text-gray-100 mb-6">
                    {{ __("You're logged in!") }}
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Line Chart for Payments -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Payments Over Time</h3>
                        <canvas id="paymentsLineChart" width="400" height="250"></canvas>
                    </div>

                    <!-- Bar Chart for Proxies -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Proxies Count</h3>
                        <canvas id="proxiesBarChart" width="400" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const paymentsData = {
            labels: @json($monthLabels),
            datasets: [{
                label: 'Number of Payments',
                data: @json($paymentsData),
                borderColor: 'rgba(99, 102, 241, 1)',
                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
                type: 'line',
            }]
        };

        const proxiesData = {
            labels: @json($proxiesLabels),
            datasets: [{
                label: 'Proxies Count',
                data: @json($proxiesData),
                backgroundColor: [
                    'rgba(239, 68, 68, 0.7)', // أحمر
                    'rgba(34, 197, 94, 0.7)', // أخضر
                    'rgba(234, 179, 8, 0.7)'  // أصفر
                ],
                borderColor: 'rgba(0,0,0,0.1)',
                borderWidth: 1,
                type: 'bar',
            }]
        };

        const paymentsConfig = {
            type: 'line',
            data: paymentsData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 5 }
                    }
                }
            },
        };

        const proxiesConfig = {
            type: 'bar',
            data: proxiesData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 5 }
                    }
                }
            }
        };

        new Chart(document.getElementById('paymentsLineChart'), paymentsConfig);
        new Chart(document.getElementById('proxiesBarChart'), proxiesConfig);
    </script>
</x-app-layout>
