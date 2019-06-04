<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>  
  <h1>Consultas</h1>
  
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>


    {!! $chart->container() !!}
    {!! $chart->script() !!}

</body>
</html>