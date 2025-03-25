// Fungsi untuk mendapatkan data baru berdasarkan rentang waktu
function getChartData(chartType, timeRange) {
    if (chartType === "project") {
        if (timeRange === "7") {
            return {
                labels: [
                    "Day 1",
                    "Day 2",
                    "Day 3",
                    "Day 4",
                    "Day 5",
                    "Day 6",
                    "Day 7",
                ],
                data: [10, 15, 20, 25, 30, 35, 40],
            };
        } else if (timeRange === "30") {
            return {
                labels: Array.from({ length: 30 }, (_, i) => `Day ${i + 1}`),
                data: Array.from({ length: 30 }, () =>
                    Math.floor(Math.random() * 50)
                ),
            };
        } else if (timeRange === "12") {
            return {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                data: [
                    100, 120, 150, 170, 200, 180, 220, 240, 210, 230, 250, 270,
                ],
            };
        }
    } else if (chartType === "revenue") {
        if (timeRange === "7") {
            return {
                labels: [
                    "Day 1",
                    "Day 2",
                    "Day 3",
                    "Day 4",
                    "Day 5",
                    "Day 6",
                    "Day 7",
                ],
                data: [1000, 1500, 2000, 2500, 3000, 3500, 4000],
            };
        } else if (timeRange === "30") {
            return {
                labels: Array.from({ length: 30 }, (_, i) => `Day ${i + 1}`),
                data: Array.from({ length: 30 }, () =>
                    Math.floor(Math.random() * 5000)
                ),
            };
        } else if (timeRange === "12") {
            return {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                data: [
                    15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000,
                    55000, 60000, 65000, 70000,
                ],
            };
        }
    }
}

// Fungsi untuk memperbarui chart berdasarkan data baru
function updateChart(chart, newLabels, newData) {
    chart.data.labels = newLabels;
    chart.data.datasets[0].data = newData;
    chart.update();
}

document.addEventListener('DOMContentLoaded', function() {
    const projectCtx = document.getElementById("projectChart").getContext("2d");
    const revenueCtx = document.getElementById("revenueChart").getContext("2d");

    // Format labels to Indonesian months
    const monthNames = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    // Group data by month
    function groupDataByMonth(data) {
        const monthlyData = Array(12).fill(0);
        data.forEach(item => {
            // Parse the month directly from the data
            const month = parseInt(item.month) - 1; // Subtract 1 as months are 0-based in JS
            monthlyData[month] += parseInt(item.total || 0);
        });
        return monthlyData;
    }

    // Group revenue data by month
    function groupRevenueByMonth(data) {
        const monthlyData = Array(12).fill().map(() => ({
            pemasukan: 0,
            pengeluaran: 0,
            total: 0
        }));

        data.forEach(item => {
            // Parse the month directly from the data
            const month = parseInt(item.month) - 1; // Subtract 1 as months are 0-based in JS
            monthlyData[month].pemasukan += parseInt(item.pemasukan || 0);
            monthlyData[month].pengeluaran += parseInt(item.pengeluaran || 0);
            monthlyData[month].total = monthlyData[month].pemasukan - monthlyData[month].pengeluaran;
        });

        return monthlyData;
    }

    // Process monthly data
    const monthlyProjectData = groupDataByMonth(projectData);
    const monthlyRevenueData = groupRevenueByMonth(revenueData);

    // Initialize Project Chart
    const projectChart = new Chart(projectCtx, {
        type: "bar",
        data: {
            labels: monthNames,
            datasets: [{
                label: "Proyek",
                data: monthlyProjectData,
                backgroundColor: "#ff6842",
                borderColor: "transparent",
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Initialize Revenue Chart
    const revenueChart = new Chart(revenueCtx, {
        type: "bar",
        data: {
            labels: monthNames,
            datasets: [
                {
                    label: "Pemasukan",
                    data: monthlyRevenueData.map(item => item.pemasukan),
                    backgroundColor: "#4CAF50",
                    borderColor: "transparent",
                    borderWidth: 0,
                },
                {
                    label: "Pengeluaran",
                    data: monthlyRevenueData.map(item => item.pengeluaran),
                    backgroundColor: "#f44336",
                    borderColor: "transparent",
                    borderWidth: 0,
                },
                {
                    label: "Total Pendapatan",
                    data: monthlyRevenueData.map(item => item.total),
                    backgroundColor: "#ff6842",
                    borderColor: "transparent",
                    borderWidth: 0,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
});
