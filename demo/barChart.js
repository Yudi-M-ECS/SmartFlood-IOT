// demo/barChart.js

document.addEventListener("DOMContentLoaded", function () {
  // Mengambil data dari server menggunakan fetch API (sesuaikan jika diperlukan)
  // fetch('demo/getBarData.php')
  //     .then(response => response.json())
  //     .then(data => {
  //         // Definisikan chart sesuai data
  //     })
  //     .catch(error => {
  //         console.error('Error fetching data:', error);
  //     });

  // Contoh data statis
  const data = {
    labels: ["Tegangan"],
    datasets: [
      {
        label: "Tegangan (Voltage)",
        data: [5],
        backgroundColor: "rgba(2,117,216,1)",
        borderColor: "rgba(2,117,216,1)",
        borderWidth: 1,
      },
    ],
  };

  const config = {
    type: "bar",
    data: data,
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true,
        },
        title: {
          display: true,
          text: "Jumlah Tegangan",
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
              return `${label}: ${value} V`;
            },
          },
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          max: 12,
          ticks: {
            stepSize: 2,
          },
          title: {
            display: true,
            text: "Tegangan (V)",
          },
        },
        x: {
          title: {
            display: true,
            text: "Kategori",
          },
        },
      },
    },
  };

  const ctx = document.getElementById("barChart").getContext("2d");
  const myBarChart = new Chart(ctx, config);
});
