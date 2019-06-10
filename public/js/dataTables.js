$(document).ready( function () {
    $('#table_id').DataTable( {
        "columnDefs": [
    		{ "title": "Fecha", "width": "15%", "targets": 0},
    		{ "title": "Motivo", "width": "15%", "targets": 1 },
    		{ "title": "Diagnóstico", "width": "45%", "targets": 2 },
    		{ "title": "Detalle", "width": "5%", "orderable": false, "targets": 3 },
    		{ "title": "Modificar", "width": "10%", "orderable": false, "targets": 4 },
    		{ "title": "Eliminar", "width": "10%", "orderable": false, "targets": 5 },
  		],
        columns: [
            { data: "Fecha" },
            { data: "Motivo" },
            { data: "Diagnóstico" },
            { data: "Detalle"},
            { data: "Modificar"},
            { data: "Eliminar"},
        ],
        language: {
        	"emptyTable": "No hay consultas",
        	"lengthMenu": "Mostrar _MENU_ consultas por página",
		    "info":           "Mostrando _START_ a _END_ de _TOTAL_ consultas",
		    "infoEmpty":      "",
		    "infoFiltered":   "(filtrado de _MAX_ consultas totales)",
		    "infoPostFix":    "",
		    "thousands":      ",",
		    "lengthMenu":     "Mostrar _MENU_ consultas",
		    "loadingRecords": "Cargando...",
		    "processing":     "Procesando...",
		    "search":         "Buscar:",
		    "zeroRecords":    "No hay resultados de la búsqueda",
		    "paginate": {
		        "first":      "Primera",
		        "last":       "Última",
		        "next":       "Anterior",
		        "previous":   "Siguiente"
		    },
		    "aria": {
		        "sortAscending":  ": orden ascendiente",
		        "sortDescending": ": orden descendiente"
		    }
		},
		autoWidth: false,
		lengthChange: false,
		pageLength: app_pages,
    } );
} );

