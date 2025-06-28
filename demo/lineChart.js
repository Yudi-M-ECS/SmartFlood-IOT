// demo/lineChart.js

document.addEventListener("DOMContentLoaded", function () {
  // Mengambil data dari server menggunakan fetch API
  fetch("demo/getAverageData.php") // Sesuaikan path jika lokasi berbeda
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        console.error("Error:", data.error);
        return;
      }

      // Set default font family dan warna
      Chart.defaults.font.family = '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
      Chart.defaults.color = "#292b2c";

      // Konfigurasi Line Chart
      const ctx = document.getElementById("lineChart").getContext("2d");
      const myLineChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: data.labels, // Hari
          datasets: [
            {
              label: "Rata-rata Tinggi Air (cm)",
              data: data.data, // Rata-rata tinggi_air
              fill: false,
              borderColor: "rgba(75, 192, 192, 1)",
              backgroundColor: "rgba(75, 192, 192, 0.2)",
              tension: 0.1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
            title: {
              display: true,
              text: "Rata-Rata Tinggi Air per Hari",
              font: {
                size: 18,
              },
            },
            tooltip: {
              enabled: true,
              callbacks: {
                label: function (context) {
                  let label = context.dataset.label || "";
                  let value = context.parsed.y || 0;
                  return `${label}: ${value} cm`;
                },
              },
            },
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: "Tinggi Air (cm)",
              },
            },
            x: {
              title: {
                display: true,
                text: "Hari",
              },
            },
          },
        },
      });
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
});
