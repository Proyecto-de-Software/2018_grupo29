function dibujar(datos) {
	Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: datos['titulo']
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        colorByPoint: true,
        data: datos['series']
    }],
    exporting: {
    chartOptions: {
      chart: {
        height: 600,
        marginBottom: 300,
        events: {
          load: function() {
            var renderer = this.renderer;

            renderer.path(['M', 30, 385, 'L', 570, 385, 'Z']).attr({
              stroke: 'black',
              'stroke-width': 1
            }).add();
            var text = document.getElementById("listado").textContent;
            renderer.text(text, 30, 400).add();
          }
        }
      },
      legend: {
        y: -220
      },
      credits: {
        position: {
          y: -220
        }
      }
    }
  }
});
}

$(document).ready(function(){
    $("#boton").click(function(){
        $(this).text(function(i, v) { return v == "Mostrar gráfico" ? "Ocultar gráfico" : "Mostrar gráfico"; });
        $("#chart").toggle();
    });
});

$(document).ready(function(){
    $("#botonlistado").click(function(){
        $(this).text(function(i, v) { return v == "Mostrar listado" ? "Ocultar listado" : "Mostrar listado"; });
        $("#listado").toggle();
    });
});


function pruebaDivAPdf() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        source = $('#listado')[0];
        specialElementHandlers = {
            '#bypassme': function (element, renderer) {
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };

        pdf.fromHTML(
            source, 
            margins.left, // x coord
            margins.top, { // y coord
                'width': margins.width, 
                'elementHandlers': specialElementHandlers
            },

            function (dispose) {
                pdf.save('Listado.pdf');
            }, margins
        );
    }