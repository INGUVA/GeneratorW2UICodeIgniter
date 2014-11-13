var listaPacientesNuevos=0;
$(function () {
});
$('#listaPaciente').w2grid({
	name: 'listaPacientes',
	header: 'Lista de Pacientes',
	url: {
		get : 'Pacientes/getListJson',
		remove: 'Pacientes/eliminar',
		save:  'Pacientes/modificar',
	},
	show: {
		selectColumn: true,
		toolbar 	: true,
		footer		: true,
		lineNumbers	: true,
		toolbarAdd	: true,
		toolbarEdit : true,
		toolbarDelete : true
	},
	multiSearch: false,
	searches:	[
		{ field: 'nombre', caption: 'Nombre', type: 'text' },
		{ field: 'fechaNacimiento', caption: 'Fecha de nacimiento', type: 'date' },
	],
   columns: [
		{ field: 'Id', caption:'Id', visible:false},
		{ field: 'nombre', caption: 'Nombre', size: '30%', resizable: true , editable: {type: "text"} , sortable: {type: "text"} },
		{ field: 'apellidos', caption: 'Apellidos', size: '30%', resizable: true , editable: {type: "text"}  },
		{ field: 'descripcion', caption: 'Descripción', size: '30%', resizable: true , editable: {type: "text"}  },
		{ field: 'empresa', caption: 'Empresa', size: '30%', resizable: true , editable: {type: "text"}  },
		{ field: 'fechaNacimiento', caption: 'Fecha de nacimiento', size: '30%', resizable: true , editable: {type: "date"} , sortable: {type: "date"} },
		{ field: 'imagen', caption: 'Imagen', size: '30%', resizable: true , editable: {type: "text"}  },
	],
	onEdit : function(event){
		openPopupModificarPaciente(event);
	},
	toolbar:{
   	onClick: function (event) {
       	if (event.target == 'w2ui-add') {
				w2ui.listaPacientes.add({ recid: listaPacientesNuevos - 1 });
				listaPacientesNuevos--;
				w2ui.listaPacientes.total=w2ui.listaPacientes+1;
			}
	    }
	}
});

$().w2form({ 
	name   : 'formNuevoPaciente',
	header : 'Nuevo paciente',
	url    : 'pacientes/nuevo',
	formURL: 'pacientes/formNuevo',
	fields : [
		{ name: 'nombreNuevoPaciente', type: 'text',  required: true },
		{ name: 'apellidosNuevoPaciente', type: 'text',  required: true },
		{ name: 'descripcionNuevoPaciente', type: 'text',  required: true },
		{ name: 'empresaNuevoPaciente', type: 'text',  required: true },
		{ name: 'fechaNacimientoNuevoPaciente', type: 'date',  required: false },
		{ name: 'imagenNuevoPaciente', type: 'text',  required: true },
	],
	tabs: [
	],
	actions: {
		reset: function () {
			this.clear();
		},
		save: function () {
			this.save();
		}
	},
	onSave : function(event){
		if(event['status']=="success"){
			this.clear();
		}
	}
});

function openPopupModificarPaciente (event) {
	var recid=event.recid;
	if(w2ui['formModificarPaciente']!=null){ w2ui['formModificarPaciente'].destroy();}
	$().w2form({
		name   : 'formModificarPaciente',
			url  : {
				get  : 'Pacientes/get/',
				save : 'Pacientes/modificar'
			},
		formURL: 'Pacientes/formModificar/',
		recid  : recid,
		record : 'Pacientes/get/'+recid,
		fields : [
		{ name: 'nombrePaciente', type: 'text',  required: true },
		{ name: 'apellidosPaciente', type: 'text',  required: true },
		{ name: 'descripcionPaciente', type: 'text',  required: true },
		{ name: 'empresaPaciente', type: 'text',  required: true },
		{ name: 'fechaNacimientoPaciente', type: 'date',  required: false },
		{ name: 'imagenPaciente', type: 'text',  required: true }		],
		tabs: [
		],
		actions: {
			reset: function () {
				this.clear();
			},
			save: function () {
				this.save();
			}
		},
		onSave: function(event){
			w2ui['listaPacientes'].reload();
		}
	});
	$().w2popup('open', {
		title	: 'Modificar paciente',
		body	: '<div id="formModificarPaciente" style="width: 100%; height: 100%; text-align:left"></div>',
		style	: 'padding: 15px 0px 0px 0px',
					width	: 800,
					height	: 500, 
					showMax : true,
		onMin	: function (event) {
			$(w2ui.foo.box).hide();
			event.onComplete = function () {
				$(w2ui.foo.box).show();
				w2ui.foo.resize();
			}
		},
		onMax	: function (event) {
			$(w2ui.foo.box).hide();
			event.onComplete = function () {
				$(w2ui.foo.box).show();
				w2ui.foo.resize();
			}
		},
		onOpen	: function (event) {
			event.onComplete = function () {
				$('#w2ui-popup #formModificarPaciente').w2render('formModificarPaciente');
			}
		}
	});
}
