(async () => {

  const respuestaRaw = await fetch("./cargar.txt");

  
  // Decodificar como JSON
  const respuesta = await respuestaRaw.json();
  // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
  // Obtener una referencia al elemento canvas del DOM
  const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX
  const datos = respuesta.datos; // <- Aquí estamos pasando el valor traído usando AJAX
  



var speedCanvas = document.getElementById("speedChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;




var Decibelios = {
  
  
labels: etiquetas,
datasets: [{
  label: "Decibelios Dbm",
  data: datos,
  lineTension: 0.1,
  fill: false,
  borderColor: 'blue'
}

]


};

var chartOptions = {
legend: {
  display: true,
  position: 'top',
  labels: {
    boxWidth: 80,
    fontColor: 'black'
  }
  
},

};


var lineChart = new Chart(speedCanvas, {
type: 'line',
data: Decibelios,
options: {
  chartOptions,
  
}

});
})();



