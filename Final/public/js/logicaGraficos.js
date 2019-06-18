function dibujar(data) {
    window.value = Highcharts.chart('grafico', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: data['titulo']
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Porcentaje: ',
            colorByPoint: true,
            data: data['series']
        }]
    });

    window.chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title: {
            text: data['titulo']
        },
        data: [{
            type: "pie",
            startAngle: 240,
            percentFormatString: "#0.##",
            toolTipContent: "{y} (#percent%)",
            indexLabel: "{name}: #percent%",
            dataPoints: data['series']
        }]
    });
    window.chart.render();
    $("#chartContainer").hide();

}

function first() {
   $.ajax({           
        type:'GET',
        url: app_url + '/reports/byGender',
        success:function(data) {
            dibujar(data['data']);
            $("#byGender").hide();
            $("#byLocation").show();
            $("#byReason").show();
            $("#listado").empty();
            $.each(data['listado'], generarListado);
        }
    });
}

$(document).ready(function(){ 
    $('#byGender').click(function () {
        $.ajax({           
            type:'GET',
            url:app_url + '/reports/byGender',
            success:function(data) {
                dibujar(data['data']);
                $("#byGender").hide();
                $("#byLocation").show();
                $("#byReason").show();
                $("#listado").empty();
                $.each(data['listado'], generarListado);
            }
        });
    });
});

$(document).ready(function(){ 
    $('#byLocation').click(function () {
        $.ajax({           
            type:'GET',
            url:app_url + '/reports/byLocation',
            success:function(data) {
                dibujar(data['data']);
                $("#byGender").show();
                $("#byLocation").hide();
                $("#byReason").show();
                $("#listado").empty();
                $.each(data['listado'], generarListado);
            }
        });
    });
});

$(document).ready(function(){ 
    $('#byReason').click(function () {
        $.ajax({           
            type:'GET',
            url:app_url + '/reports/byReason',
            success:function(data) {
                dibujar(data['data']);
                $("#byGender").show();
                $("#byLocation").show();
                $("#byReason").hide();
                $("#listado").empty();
                $.each(data['listado'], generarListado);
            }
        });
    });
});

function generarListado(index, value) {
    $("#listado").append("<h4>" + index + "</h4>");
    var html = "<ul id='" + index +"' class='list-group'>";
    $.each(value, function(index2, value2) {
        html += "<li class='list-group-item'>";
        html += "<p> Paciente: "+ value2['first_name'] + " " + value2['last_name'] + "</p> "
        html += '<p> Fecha: ' + value2['date'] + ' </p> '
        html += '<p> Diagnostico: ' + value2['diagnostic'] + '</p> </li>'
    });
    $("#listado").append(html);
    $("#listado").append('</ul> <hr>');
};

function toPdf(){

    var pdf = new jsPDF('p', 'pt', 'letter');
    chart = window.chart;
    imgData = chart.canvas.toDataURL();

    pdf.addImage(imgData, 'JPEG', 80, 20, 500, 250);

    var x = 20;
    var y = 160;
    pdf.text(10,40,'LISTADO 2019');
    $('#listado ul').each( function (index){
        pageHeight= pdf.internal.pageSize.height;
        if (y >= pageHeight - 100){
            pdf.addPage();
            y = 20 // Restart height position
        }
        pdf.text(x, y, $(this).attr("id"));
        var amount = 1;
        $(this).find('p').each( function(index){
            y += 50; // Height position of new content
            amount += 1;
            if (y >= pageHeight - 100){
                pdf.addPage();
                y = 100 // Restart height position
            }
            pdf.text(x, y, $(this).text());
            //addToPDF($(this),pdf);
        });
        y += amount*30;
    });
    pdf.save("listado.pdf");
};