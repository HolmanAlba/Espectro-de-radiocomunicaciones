<script>
var data1 = [12, 3, 2, 1, 8, 8, 2, 2, 3, 5, 7, 1];
var data2 = [{x: 1, y: 12}, {x: 2, y: 3}, {x: 3, y: 2}, {x: 4, y: 1}, {x: 5, y: 8}, {x: 6, y: 8}, {x: 7, y: 2}, {x: 8, y: 2}, {x: 9, y: 3}, {x: 10, y: 5}, {x: 11, y: 11}, {x: 12, y: 1}];
var chartData = {/*from   ww w . j a  v a2s  . c o  m*/
labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
datasets: [
{
data: data2
}
]
};
window.onload = function() {
var ctx = document.getElementById("canvas").getContext("2d");
new Chart(ctx, {
type: "line",
data: chartData,
options: {
annotation: {
  annotations: [
    {
      drawTime: "afterDatasetsDraw",
      type: "line",
      mode: "vertical",
      scaleID: "x-axis-0",
      value: 3.8,
      borderWidth: 5,
      borderColor: "red",
      label: {
        content: "TODAY",
        enabled: true,
        position: "top"
      }
    }
  ]
},
scales: {
  xAxes: [{
    type: 'linear',
    position: 'bottom',
    ticks: {
          max: 12,
          min: 1,
          stepSize: 1,
          callback: function(value, index, values) {
               return chartData.labels[index];
          }
     }
  }]
}
}
});
};
</script>  


