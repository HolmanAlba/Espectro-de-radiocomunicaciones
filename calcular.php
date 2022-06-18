<?php
//VARIABLES
try {
    if (!$_POST) {
        header('Location:index.html');
    }
} catch (\Throwable $th) {
    //throw $th;
}
$temperatura = $_POST['Temperatura'];
$anchodebandaruido = $_POST['Anchoruido'];

$frecuencia1 = (int)$_POST['frecuencia1'];
$potencia1 = (int)$_POST['potencia1'];
$anchodebanda1 = $_POST['anchodebanda1'];
$frecuencia2 = (int)$_POST['frecuencia2'];
$potencia2 = (int)$_POST['potencia2'];
$anchodebanda2 = $_POST['anchodebanda2'];
$TipoHertz = $_POST['Tipohertz'];

$pot3 = $potencia2+3;
$frecu225=$frecuencia2*0.25+$frecuencia2;
$frecu250=$frecuencia2*0.5+$frecuencia2;
$frecu275=$frecuencia2*0.75+$frecuencia2;

$frecuIzq=$frecuencia1-($anchodebanda1/2);
$frecuDer=$frecuencia1+($anchodebanda1/2);


$frecuIzq2=$frecuencia2-($anchodebanda2/2);
$frecuDer2=$frecuencia2+($anchodebanda2/2);

//FUNCIONES
function Piso_de_ruido($temperatura, $anchodebandaruido)
{
    $res = 1.35 * pow(10, -23) * $temperatura * $anchodebandaruido;

    $res = $res * 1000;
    $res = 10 * log10($res);
    return round($res, 2);
}

function Piso_de_ruidojson($temperatura, $anchodebandaruido)
{
    $res = 1.35 * pow(10, -23) * $temperatura * $anchodebandaruido;

    $res = $res * 1000;
    $datos = $res = 10 * log10($res);
    $respuesta1 = [
        "datos" => $datos, $datos, $datos
    ];
    return json_encode($respuesta1);
}

function Hertz($TipoHertz, $anchodebandaruido)
{
    $res = $anchodebandaruido;
    if ($TipoHertz == 3) {
        $res = $anchodebandaruido * pow(10, 9);
    } else if ($TipoHertz == 2) {
        $res = $anchodebandaruido * pow(10, 6);
    } else if ($TipoHertz == 1) {
        $res = $anchodebandaruido * pow(10, 3);
    } else {
    }
    return $res;
}
function Linea($Pisoderuido, $Potencia1, $frecuencia1, $Anchodebanda1, $Potencia2, $frecuencia2, $Anchodebanda2)
{
    $datos = [$Pisoderuido, ($Potencia1 - 3), $Potencia1, ($Potencia1 - 3), $Pisoderuido, $Potencia2 - 3, $Potencia2, $Potencia2 - 3, $Pisoderuido];
}

$piso = Piso_de_ruido($temperatura, Hertz($TipoHertz, $anchodebandaruido));




?>

<!DOCTYPE html>
<html lang="es">
<?php
// Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor
$etiquetas = ["Enero", "Febrero", "Marzo", "Abril"];
$datosVentas = [5000, 1500, 8000, 5102];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espectro de radiocomunicaciones</title>


    <!-- Importar chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
</head>

<body>
    <h1>Espectro de radiocomunicaciones</h1>
    <canvas id="speedChart" width="270" height="100"></canvas>


    <script type="text/javascript">
        var potencia1 = '<?= $potencia1 ?>';
        var frecuencia1 = '<?= $frecuencia1 ?>';
        var anchodebanda1 = '<?= $anchodebanda1 ?>';
        var pisoruidojav = '<?= $piso ?>';

        var potencia2 = '<?= $potencia2 ?>';
        var frecuencia2= ' <?= $frecuencia2 ?>';
        var anchodebanda2= '<?= $anchodebanda2 ?>';

        var frecu25 = ' <?= $frecu225 ?>';
        var frecu50 = ' <?= $frecu250 ?>';
        var frecu75 = ' <?= $frecu275 ?>';
        var frecuIZQ = ' <?= $frecuIzq ?>';
        var frecuDER = ' <?= $frecuDer ?>';
        var frecuIZQ2 = ' <?= $frecuIzq2?>';
        var frecuDER2 = ' <?= $frecuDer2 ?>';

        
        var speedCanvas = document.getElementById("speedChart");

        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;


        var dataFive = {
            label: "Piso de ruido",
            data: [pisoruidojav,numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-2),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-2),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-5),numeroAleatorioDecimales(pisoruidojav,pisoruidojav-50)],
            lineTension: 0.1,
            fill: 'start',
            backgroundColor: 'rgba(11, 6, 80, 1)',
        };
        var dataFirst = {
            label: "Señal 1 dB",
            data: [pisoruidojav, pisoruidojav, pisoruidojav, pisoruidojav,potencia1-3,potencia1,potencia1-3,pisoruidojav,pisoruidojav,pisoruidojav,pisoruidojav],
            lineTension: 0.1,
            fill: 'start',
            backgroundColor: 'rgba(102, 215, 209, 1)',
        };
        var dataSecond = {
            label: "Señal 2 dB",
            data: [pisoruidojav, pisoruidojav, pisoruidojav, pisoruidojav, pisoruidojav, pisoruidojav, pisoruidojav,potencia2-3,potencia2,potencia2-3,pisoruidojav,pisoruidojav,pisoruidojav,pisoruidojav,pisoruidojav],
            lineTension: 0.1,
            fill: 'start',
            backgroundColor: 'rgba(190, 173, 243, 1)',
        };
        var dataThird = {
            label: "Potencia señal 1",
            data: [potencia1,potencia1,potencia1,potencia1,potencia1,potencia1,potencia1,potencia1,potencia1,potencia1,potencia1,potencia1,potencia1,potencia1,potencia1],
            fill: false,
            borderColor: 'rgba(102, 215, 209, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        };
        var dataFourth = {
            label: "Potencia señal 2",
            data: [potencia2,potencia2,potencia2,potencia2,potencia2,potencia2,potencia2,potencia2,potencia2,potencia2,potencia2,potencia2,potencia2,potencia2,potencia2],
            fill: false,
            borderColor: 'rgba(172, 168, 241, 1)', // Color del borde
            borderWidth: 2, // Ancho del borde
        };

      


        var speedData = {
        labels: [0, frecuencia1 * 0.25, frecuencia1 * 0.5, frecuencia1 * 0.75,frecuIZQ ,frecuencia1,frecuDER,
                
            ((frecuencia2-frecuencia1)/2)-frecuencia2*-1,frecuIZQ2 ,frecuencia2,frecuDER2 ,frecu25, frecu50, frecu75,frecuencia2*2],
            datasets: [dataFive,dataFirst, dataSecond,dataThird,dataFourth],
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

        numeroAleatorioDecimales(pisoruidojav,pisoruidojav-20)


    function numeroAleatorioDecimales(max, min) {
        var num = Math.random() * (max - min);
        return num + min;
        }

        var lineChart = new Chart(speedCanvas, {
        type: 'line',
        data: speedData,
        options: chartOptions
        });
    </script>
</body>

</html>