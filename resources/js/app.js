import './bootstrap';
import 'preline';
// import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';
import flatpickr from 'flatpickr';
import { Calendar } from '@fullcalendar/core';

// Debugging
console.log('App JS Loading...');

// Assign to window object
// window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Map imports
    if (document.querySelector('#mapOne')) {
        import('./components/map').then(module => module.initMap());
    }

    // Chart imports
    const chartIds = [
        { id: 'chartOne', file: './components/chart/chart-1', func: 'initChartOne' },
        { id: 'chartTwo', file: './components/chart/chart-2', func: 'initChartTwo' },
        { id: 'chartThree', file: './components/chart/chart-3', func: 'initChartThree' },
        { id: 'chartSix', file: './components/chart/chart-6', func: 'initChartSix' },
        { id: 'chartEight', file: './components/chart/chart-8', func: 'initChartEight' },
        { id: 'chartThirteen', file: './components/chart/chart-13', func: 'initChartThirteen' }
    ];

    chartIds.forEach(chart => {
        if (document.querySelector(`#${chart.id}`)) {
            console.log(`Loading chart: ${chart.id}`);
            import(`${chart.file}`).then(module => {
                if (module[chart.func]) {
                    module[chart.func]();
                } else {
                    console.error(`Method ${chart.func} not found in ${chart.file}`);
                }
            }).catch(err => {
                console.error(`Failed to load chart ${chart.id}:`, err);
            });
        }
    });

    // Calendar init
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(module => module.calendarInit());
    }
});

// Start Alpine
// Alpine.start();
// console.log('Alpine started');
