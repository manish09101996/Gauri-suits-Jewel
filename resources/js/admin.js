import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

// Initialize Admin Dashboard Charts
window.initAdminDashboardCharts = function(revenueData, topProductsData, categoryData) {
    // 1. Revenue Over Time Chart
    const revCtx = document.getElementById('revenueChart');
    if (revCtx && revenueData) {
        const ctx = revCtx.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(197, 168, 105, 0.4)');
        gradient.addColorStop(1, 'rgba(197, 168, 105, 0.0)');

        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: revenueData.labels,
                datasets: [{
                    label: 'Revenue (₹)',
                    data: revenueData.revenue,
                    borderColor: '#C5A869',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#58111A',
                    pointBorderColor: '#C5A869',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Revenue: ₹' + context.parsed.y.toLocaleString('en-IN');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#8C713B', font: { size: 11 } }
                    },
                    y: {
                        grid: { color: '#EFE9DE', drawBorder: false },
                        ticks: {
                            color: '#8C713B',
                            font: { size: 11 },
                            callback: function(val) { return '₹' + val.toLocaleString('en-IN'); }
                        }
                    }
                }
            }
        });
    }

    // 2. Top Products Bar Chart
    const topCtx = document.getElementById('topProductsChart');
    if (topCtx && topProductsData) {
        new Chart(topCtx, {
            type: 'bar',
            data: {
                labels: topProductsData.labels,
                datasets: [{
                    label: 'Units Sold',
                    data: topProductsData.quantities,
                    backgroundColor: '#58111A',
                    borderRadius: 4,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        grid: { color: '#EFE9DE' },
                        ticks: { color: '#8C713B', stepSize: 1 }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { color: '#2A1810', font: { size: 12 } }
                    }
                }
            }
        });
    }

    // 3. Category Distribution Doughnut Chart
    const catCtx = document.getElementById('categoryChart');
    if (catCtx && categoryData && categoryData.labels.length > 0) {
        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.labels,
                datasets: [{
                    data: categoryData.revenues,
                    backgroundColor: [
                        '#58111A',
                        '#C5A869',
                        '#7A1D2A',
                        '#D4AF37',
                        '#430D14',
                        '#A88B4D',
                    ],
                    borderWidth: 2,
                    borderColor: '#FFFFFF',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { size: 11 }, boxWidth: 12 }
                    }
                },
                cutout: '65%'
            }
        });
    }
};

Alpine.data('adminLayout', () => ({
    sidebarOpen: window.innerWidth >= 1024,
    sidebarCollapsed: localStorage.getItem('admin_sidebar_collapsed') === 'true',

    toggleCollapse() {
        this.sidebarCollapsed = !this.sidebarCollapsed;
        localStorage.setItem('admin_sidebar_collapsed', this.sidebarCollapsed);
    },

    toggleMobileSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
    }
}));

Alpine.start();
