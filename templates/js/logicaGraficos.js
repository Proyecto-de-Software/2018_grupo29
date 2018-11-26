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
            enabled: true
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