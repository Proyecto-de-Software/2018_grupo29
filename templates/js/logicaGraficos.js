function dibujar(datos) {
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title: {
            text: datos['titulo']
        },
        data: [{
            type: "pie",
            startAngle: 240,
            yValueFormatString: "##0.00\"%\"",
            indexLabel: "{name} {y}",
            dataPoints: datos['series']
        }]
    });
    chart.render();
    var canvas = $("#chartContainer .canvasjs-chart-canvas").get(0);
    var dataURL = canvas.toDataURL();
    //console.log(dataURL);
    $("#exportButton").click(function(){
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF('p', 'pt', 'letter');
        pdf.addImage(dataURL, 'JPEG', 100, 20, 450, 120); //addImage(image, format, x-coordinate, y-coordinate, width, height)
        var x = 20;
        var y = 160;
        $('#listado ul').each( function (index){
            //console.log($(this).find('li'));
            //console.log($(this).contents());
            pageHeight= pdf.internal.pageSize.height;
            console.log(pdf.internal.pageSize.height,y);
            if (y >= pageHeight - 100){
                pdf.addPage();
                y = 20 // Restart height position
            }
            //console.log($(this).attr("id"));
            pdf.text(x, y, $(this).attr("id"));
            var amount = 1;
            $(this).find('li').each( function(index){
                //console.log($(this).text());
                //console.log($(this).contents());
                // Before adding new content
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
        pdf.save("download.pdf");
    });

}

function addToPDF(source,pdf){
    specialElementHandlers = {
        '#bypassme': function (element, renderer) {
            return true
        }
    };
    pageHeight= pdf.internal.pageSize.height;
    var tm = 80;
    if (tm >= pageHeight){
        doc.addPage();
        tm = 0 // Restart height position
    }
    margins = {
        top: tm,
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