<?php
    //Crea un archivo de texto para guardar los datos que envía el ESP8266
if (!file_exists("Experimentos.txt")){
    // si no existe el archivo, lo creamos
    file_put_contents("Experimentos.txt", "0.0\r\n0.0");
}

    //Si se recibe Datos con el Método GET, los procesamos
    if (isset($_GET['Temp']) && isset($_GET['Hum'])){
        $var3 = $_GET['Temp'];
        $var4 = $_GET['Hum'];
        //$var5 = $_GET['Hid'];
        $fileContent = $var3 . "\r\n" . $var4;
        $fileSave = file_put_contents("miTemp&Hum.txt", $fileContent);
    }elseif ($fileSave=null) {

        echo "<h3 class='alerta1'>Servidor desconectdo</h3>";
    }

    //Leemos los datos del archivo para guardarlos en variables
    $fileStr = file_get_contents("miTemp&Hum.txt");
    $pos1 = strpos($fileStr, "\r\n");
    $var1 = substr($fileStr, 0, $pos1);
    $var2 = substr($fileStr, 5, 7); //de la pos1 +1 hasta el final
    $var5 = substr($fileStr, 16, 20);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <meta http-equiv="refresh" content="15">

    <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/3.1.0/jquery.min.js"></script>


    <title>SCADA</title>

</head>

<body>
    <header>
        <h1>Sistema SCADA</h1>
    </header>

<?php
if ($var1<=0){
    echo "<h3 class='alerta1'>ALERTA: Servidor o sensor DHT22 desconectdo.</h3>";
}
?>

<?php
if ($var5<=0){
    echo "<h3 class='alerta1'>ALERTA: Servidor o sensor MQ-8 desconectdo.</h3>";
}
?>

<?php
if ($var1>25){
    echo "<h3 class='alerta1'>ALERTA: Temperatura alta.</h3>";
}
?>

<?php
if ($var2>50){
    echo "<h3 class='alerta1'>ALERTA: Humedad alta.</h3>";
}
?>

<?php
if ($var5>900){
    echo "<h3 class='alerta1'>ALERTA: Niveles altos de Hidrogeno en el aire.</h3>";
}
?>

<?php
if ($var5>1000){
    $var5=1000;
}
?>

<!--primero-->
<figure class="highcharts-figure">
    
    <div id="temperatura" class="chart-container"></div>
    <h4 style="font-size:30px;color: #000000">Temperatura</h4>
</figure>
<!--segundo-->
<figure class="highcharts-figure">
    
    <div id="humedad" class="chart-container"></div>
    <h4 style="font-size:30px;color: #000000">Humedad</h4>
</figure>
<!--tercero-->
<figure class="highcharts-figure">
     
    <div id="hidrogeno" class="chart-container"></div>
    <h4 style="font-size:30px;color: #000000">Hidrogeno</h4>
</figure>
    <section class="TH">
        <h2 style="background-color: #00FFDE">Temperatura: <?php echo $var1; ?>°C</h2>
        <h2 style="background-color: #00FFDE">Humedad: <?php echo $var2; ?>%</h2>
        <h2 style="background-color: #00FFDE">Hidrogeno: <?php echo $var5; ?>ppm</h2>
        
    </section>

<!--primero-->
<script type="text/javascript">
var gaugeOptions = {
    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '140%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    exporting: {
        enabled: false
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        tickWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// The speed gauge
var chartSpeed = Highcharts.chart('temperatura', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 30,
        title: {
            text: ''
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Speed',
        data: [<?php echo $var1; ?>],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y}</span><br/>' +
                '<span style="font-size:12px;opacity:0.4">%</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: ' °C'
        }
    }]

}));
</script>

<!--segundo-->
<script type="text/javascript">
var gaugeOptions = {
    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '140%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    exporting: {
        enabled: false
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        tickWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// The speed gauge
var chartSpeed = Highcharts.chart('humedad', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 49,
        title: {
            text: ''
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Speed',
        data: [<?php echo $var2; ?>],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y}</span><br/>' +
                '<span style="font-size:12px;opacity:0.4">%</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: ' °C'
        }
    }]

}));
</script>

<!--tercero-->
<script type="text/javascript">
var gaugeOptions = {
    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '140%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    exporting: {
        enabled: false
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        tickWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// The speed gauge
var chartSpeed = Highcharts.chart('hidrogeno', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 1000,
        title: {
            text: ''
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Speed',
        data: [<?php echo $var5; ?>],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y}</span><br/>' +
                '<span style="font-size:12px;opacity:0.4">ppm</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: ' °C'
        }
    }]

}));
</script>

</body>
</html>