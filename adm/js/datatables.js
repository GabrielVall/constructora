function fn_config_datatable_1(lengthChange,ordering,fixed_left,fixed_right){
	var configuracion_tabla = {
		"language": {
			"emptyTable": "Datos no disponibles en tabla",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "",
			"search": "Buscar:",
			"zeroRecords": "No se encontraron resultados similares en la busqueda",
			"infoFiltered": "(filtrado de un total de _MAX_ registros)",
			"scrollX": "true",
			"paginate": {
				"previous": "Ant.",
				"next": "Sig."
			},
			"lengthMenu": "Mostrar _MENU_ resultados"
		},
		"lengthChange": lengthChange,
		"ordering": ordering,
		fixedColumns:   {
			left: fixed_left,
			right: fixed_right
		},
		columnDefs: [
			{ orderable: false, targets: -1 }
		  ]
	};
	return configuracion_tabla;
}