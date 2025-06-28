// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#292b2c";

// Bar Chart Example
var ctx = document.getElementById("pie-chart");
var myLineChart = new Chart(ctx, {
  type: "pie",
  data: {
    labels: ["Januari", "February"],
    datasets: [
      {
        data: [12.21, 22],
        backgroundColor: ["#007bff", "#007bff"],
      },
    ],
  },
});
