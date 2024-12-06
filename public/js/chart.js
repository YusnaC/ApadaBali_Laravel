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

// Pilih elemen kanvas
const projectCtx = document.getElementById("projectChart").getContext("2d");
const revenueCtx = document.getElementById("revenueChart").getContext("2d");

// Data awal untuk kedua chart
const projectChartData = getChartData("project", "7");
const revenueChartData = getChartData("revenue", "7");

// Inisialisasi Chart.js untuk chart proyek
// Inisialisasi Chart.js untuk chart proyek
const projectChart = new Chart(projectCtx, {
    type: "bar",
    data: {
        labels: projectChartData.labels,
        datasets: [
            {
                label: "Proyek",
                data: projectChartData.data,
                backgroundColor: "#ff6842", // Warna chart
                borderColor: "transparent", // Menghapus border
                borderWidth: 0, // Menghapus border
            },
        ],
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});

// Inisialisasi Chart.js untuk chart pendapatan
const revenueChart = new Chart(revenueCtx, {
    type: "bar",
    data: {
        labels: revenueChartData.labels,
        datasets: [
            {
                label: "Pendapatan",
                data: revenueChartData.data,
                backgroundColor: "#ff6842", // Warna chart
                borderColor: "transparent", // Menghapus border
                borderWidth: 0, // Menghapus border
            },
        ],
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});

// Event Listener untuk memperbarui chart berdasarkan filter waktu
// document.getElementById("timeFilterProject").addEventListener("change", (e) => {
//   const newData = getChartData("project", e.target.value);
//   updateChart(projectChart, newData.labels, newData.data);
// });

// document.getElementById("timeFilterRevenue").addEventListener("change", (e) => {
//   const newData = getChartData("revenue", e.target.value);
//   updateChart(revenueChart, newData.labels, newData.data);
// });
