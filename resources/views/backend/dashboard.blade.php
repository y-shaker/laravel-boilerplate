@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Welcome :Name', ['name' => $logged_in_user->name])
        </x-slot>

        <x-slot name="body">
            @lang('Welcome to the Dashboard')


            <!-- Display pie chart here using JavaScript library like Chart.js -->
            <div class="chart-container">
            <h3>Total Users: {{ $userCount }}</h3>
                <div class="chart">
                    <canvas id="userPieChart"></canvas>
                </div>

                <div class="chart">
                    <canvas id="userBarChart"></canvas>
                </div>
            </div>
        </x-slot>
    </x-backend.card>

    <style>
        .chart-container {
            display: flex;
            align-items: center;
        }

        .chart {
            flex: 1; /* Use flex property to distribute space evenly */
            max-width: 60500px; /* Adjust the maximum width as needed */
            margin: 0 3px; /* Adjust the margin to control spacing between charts */        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('userPieChart').getContext('2d');
            var data = {!! json_encode($userDistribution) !!};

            var labels = data.map(function (item) {
                return item.type;
            });
            var values = data.map(function (item) {
                return item.count;
            });

            var pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            // Add more colors for other types
                        ],
                    }],
                },
                options: {
                    aspectRatio: 2.5, // Set the aspect ratio (1 for a square chart)
                    responsive: true, // Enable responsiveness
                },
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var ctx_2 = document.getElementById('userBarChart').getContext('2d');
            var data_2 = {!! json_encode($userRegistrations) !!};

            var labels_2 = data_2.map(function (item) {
                return item.date;
            });
            var values_2 = data_2.map(function (item) {
                return item.count;
            });

            var barChart = new Chart(ctx_2, {
                type: 'bar',
                data: {
                    labels: labels_2,
                    datasets: [{
                        label: 'User Registrations',
                        data: values_2,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)', // Bar color
                        borderColor: 'rgba(75, 192, 192, 1)', // Border color
                        borderWidth: 1,
                    }],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1, // Set step size for Y-axis (number of users)
                        },
                    },
                },
            });
        });
    </script>
@endsection
