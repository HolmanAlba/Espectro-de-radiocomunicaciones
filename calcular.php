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
   $datos= $res = 10 * log10($res);
    $respuesta1 = [
        "datos" => $datos,$datos,$datos
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
    $datos = [$Pisoderuido, ($Potencia1 - 3), $Potencia1, ($Potencia1 - 3), $Pisoderuido, $Potencia2 - 3,$Potencia2 ,$Potencia2 - 3, $Pisoderuido];


    $etiquetas = [
        0, $frecuencia1 - ($Anchodebanda1 / 2), $frecuencia1, $frecuencia1 + ($Anchodebanda1 / 2), (($frecuencia2 - $frecuencia1) / 2) + $frecuencia1,

        $frecuencia2 - ($Anchodebanda2 / 2), $frecuencia2, $frecuencia2 + ($Anchodebanda2 / 2), (($frecuencia2 - $frecuencia1) / 2 + $frecuencia2)
    ];

    $respuesta = [
        "etiquetas" => $etiquetas,
        "datos" => $datos,
    ];
    return json_encode($respuesta);
}

$piso = Piso_de_ruido($temperatura, Hertz($TipoHertz, $anchodebandaruido));

$file = fopen("cargar.txt", "w+");

fwrite($file, Linea($piso, $potencia1, $frecuencia1, $anchodebanda1, $potencia2, $frecuencia2, $anchodebanda2) . PHP_EOL);

fclose($file);


$file = fopen("pisoruido.txt", "w+");

fwrite($file, Piso_de_ruidojson($temperatura, Hertz($TipoHertz, $anchodebandaruido)) . PHP_EOL);

fclose($file);




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <title>Espectograma</title>
</head>

<body>

    <div id="chartContainer" style="height: 300px; width: 100%;">
        <canvas id="speedChart" width="5" height="2"></canvas>
        <script type="text/javascript" src="scriptson.js"></script>


    </div>
</body>

</html>