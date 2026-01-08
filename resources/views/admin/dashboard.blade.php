@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Chart Section -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Statistik Kegiatan Latihan</h3>
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter: {{ ucfirst($currentFilter == 'daily' ? 'Harian' : ($currentFilter == 'weekly' ? 'Mingguan' : 'Bulanan')) }}
                    </button>
                    <div x-show="open" class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg shadow-lg z-10 py-1" style="display: none;">
                        <a href="?filter=daily" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 {{ $currentFilter == 'daily' ? 'font-bold bg-gray-50' : '' }}">Harian</a>
                        <a href="?filter=weekly" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 {{ $currentFilter == 'weekly' ? 'font-bold bg-gray-50' : '' }}">Mingguan</a>
                        <a href="?filter=monthly" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 {{ $currentFilter == 'monthly' ? 'font-bold bg-gray-50' : '' }}">Bulanan</a>
                    </div>
                </div>
            </div>
            <div id="chart"></div>
        </div>

        <!-- Lists Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Active Coaches -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Pelatih Teraktif</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3 text-right">Total Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coaches as $coach)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden flex items-center justify-center text-gray-500">
                                            @if ($coach->avatar)
                                                <img src="{{ asset($coach->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-xs font-bold">{{ substr($coach->name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p>{{ $coach->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $coach->username }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ $coach->total_schedules }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-3 text-center">Belum ada data pelatih.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Active Athletes -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Atlit Teraktif</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3">Total Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($athletes as $athlete)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 overflow-hidden flex items-center justify-center">
                                            @if ($athlete->avatar)
                                                <img src="{{ asset($athlete->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-xs font-bold">{{ substr($athlete->name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p>{{ $athlete->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $athlete->username }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 font-bold text-gray-700 dark:text-gray-200">
                                        {{ $athlete->total_point ?? 0 }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-3 text-center">Belum ada data atlit.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                series: [{
                    name: 'Kegiatan',
                    data: @json($chartData)
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'Inter, sans-serif',
                    background: 'transparent'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    categories: @json($chartLabels),
                    labels: {
                        style: {
                            colors: '#9ca3af',
                            fontSize: '12px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        },
                        style: {
                            colors: '#9ca3af',
                            fontSize: '12px'
                        }
                    }
                },
                grid: {
                    borderColor: '#374151',
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                colors: ['#3b82f6'],
                theme: {
                    mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                },
                tooltip: {
                    theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                    y: {
                        formatter: function (val) {
                            return val + " Kegiatan"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
@endsection