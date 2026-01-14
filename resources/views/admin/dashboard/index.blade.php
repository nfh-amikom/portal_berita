@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
        {{-- <p class="text-gray-700 mb-4">Welcome to the admin panel. Use the navigation to manage content.</p> --}}
        <div class="mt-6 flex flex-wrap gap-4">
            <a href="{{ route('admin.news.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                Manage News
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users.index') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                Manage Users
            </a>
            @endif
        </div>
        <div class="mt-10 border-t pt-8">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full lg:w-1/2 px-4 mb-8 lg:mb-0">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Top 5 Most Viewed News (Last 7 Days)</h2>
                    <div class="relative h-64 w-full">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 px-4">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Total Views Per Day</h2>
                    <div class="relative h-64 w-full">
                        <canvas id="dailyViewsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}" class="mt-12 border-t pt-6">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                Logout
            </button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Changed to bar chart
            data: {
                labels: @json($chartLabels), // Dynamic labels from controller
                datasets: [{
                    label: 'Total Views'
                    , data: @json($chartData), // Dynamic data from controller
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.6)', // blue-500
                        'rgba(168, 85, 247, 0.6)', // purple-500
                        'rgba(249, 115, 22, 0.6)', // orange-500
                        'rgba(234, 88, 12, 0.6)', // red-500
                        'rgba(22, 163, 74, 0.6)' // green-500
                    ]
                    , borderColor: [
                        'rgb(59, 130, 246)'
                        , 'rgb(168, 85, 247)'
                        , 'rgb(249, 115, 22)'
                        , 'rgb(234, 88, 12)'
                        , 'rgb(22, 163, 74)'
                    ]
                    , borderWidth: 1
                }]
            }
            , options: {
                responsive: true
                , maintainAspectRatio: false
                , plugins: {
                    legend: {
                        display: false
                    , }
                    , title: {
                        display: true
                        , text: 'Top 5 Most Viewed News (Last 7 Days)'
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            }
                        }
                    }
                }
                , scales: {
                    y: {
                        beginAtZero: true
                        , title: {
                            display: true
                            , text: 'Views'
                        }
                    }
                    , x: {
                        title: {
                            display: true
                            , text: 'News Article Title'
                        }
                        , ticks: {
                            callback: function(value) {
                                const label = this.getLabelForValue(value);
                                if (label.length > 15) { // Batasi 15 karakter
                                    return label.substring(0, 15) + '...';
                                }
                                return label;
                            }
                            , maxRotation: 45,
                            minRotation: 0
                        }
                    }
                }
            }
        });
        // Chart for Daily Views
        const dailyCtx = document.getElementById('dailyViewsChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line'
            , data: {
                labels: @json($dailyViewsLabels)
                , datasets: [{
                    label: 'Views Per Day'
                    , data: @json($dailyViewsData)
                    , borderColor: 'rgb(75, 192, 192)', // a nice green-blue color
                    backgroundColor: 'rgba(75, 192, 192, 0.2)'
                    , tension: 0.4
                    , fill: true
                }]
            }
            , options: {
                responsive: true
                , maintainAspectRatio: false
                , plugins: {
                    legend: {
                        position: 'top'
                    , }
                    , title: {
                        display: true
                        , text: 'News Views Per Day (Last 7 Days)'
                    }
                }
                , scales: {
                    y: {
                        beginAtZero: true
                        , title: {
                            display: true
                            , text: 'Views'
                        }
                    }
                    , x: {
                        title: {
                            display: true
                            , text: 'Date'
                        }
                    }
                }
            }
        });
    });

</script>
@endsection
