var listaTratamientospacientes = new Array();
var listaTratamientosNuevos=0;
$(function () {
$.getJSON(base_url+'pacientes/getEnum', function (data) {
$(data.records).each(function(){
	listaTratamientospacientes.push({id:this.id, text:this.text});
	w2ui.listaTratamientos.getColumn('paciente').editable.items = listaTratamientospacientes;
	});
});});
$('#listaTratamiento').w2grid({
	name: 'listaTratamientos',
	header: 'Lista de Tratamientos',
	url: {
		get : 'Tratamientos/getListJson',
		remove: 'Tratamientos/eliminar',
		save:  'Tratamientos/modificar',
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
		{ field: 'descripcion', caption: 'Descripción', type: 'text' },
		{ field: 'fechaInicio', caption: 'Fecha de inicio', type: 'date' },
		{ field: 'fechaFinal', caption: 'Fecha de fin', type: 'date' },
		{ field: 'paciente', caption: 'Paciente', type: 'select' },
		{ field: 'finalizado', caption: 'Finalizado', type: 'checkbox' },
	],
   columns: [
		{ field: 'Id', caption:'Id', visible:false},
		{ field: 'descripcion', caption: 'Descripción', size: '30%', resizable: true , editable: {type: "text"} , sortable: {type: "text"} },
		{ field: 'fechaInicio', caption: 'Fecha de inicio', size: '30%', resizable: true , editable: {type: "date"} , sortable: {type: "date"} },
		{ field: 'fechaFinal', caption: 'Fecha de fin', size: '30%', resizable: true , editable: {type: "date"} , sortable: {type: "date"} },
		{ field: 'paciente', caption: 'Paciente', size: '30%', resizable: true , editable: {type: "select"}  ,render: function (record, index, col_index) {var html = '';for (var p in listaTratamientospacientes) {	if(record.changes!=undefined && record.changes.paciente!=undefined){		if (listaTratamientospacientes[p].id == record.changes.paciente) 			html = listaTratamientospacientes[p].text;	}else{		if (listaTratamientospacientes[p].id == w2ui.listaTratamientos.get(record.recid).pacienteId) 			html = listaTratamientospacientes[p].text;		}}	return html|| '';}},
		{ field: 'finalizado', caption: 'Finalizado', size: '30%', resizable: true , editable: {type: "checkbox"}  },
	],
	onEdit : function(event){
		openPopupModificarTratamiento(event);
	},
	toolbar:{
   	onClick: function (event) {
       	if (event.target == 'w2ui-add') {
				w2ui.listaTratamientos.add({ recid: listaTratamientosNuevos - 1 });
				listaTratamientosNuevos--;
				w2ui.listaTratamientos.total=w2ui.listaTratamientos+1;
			}
	    }
	}
});

$().w2form({ 
	name   : 'formNuevoTratamiento',
	header : 'Nuevo tratamiento',
	url    : 'tratamientos/nuevo',
	formURL: 'tratamientos/formNuevo',
	fields : [
		{ name: 'descripcionNuevoTratamiento', type: 'text',  required: true },
		{ name: 'fechaInicioNuevoTratamiento', type: 'date',  required: true },
		{ name: 'fechaFinalNuevoTratamiento', type: 'date',  required: true },
		{ name: 'pacienteNuevoTratamiento', type: 'select',  options : { url : "null", showNone : true}, required: true },
		{ name: 'finalizadoNuevoTratamiento', type: 'checkbox',  required: true },
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

function openPopupModificarTratamiento (event) {
	var recid=event.recid;
	if(w2ui['formModificarTratamiento']!=null){ w2ui['formModificarTratamiento'].destroy();}
	$().w2form({
		name   : 'formModificarTratamiento',
			url  : {
				get  : 'Tratamientos/get/',
				save : 'Tratamientos/modificar'
			},
		formURL: 'Tratamientos/formModificar/',
		recid  : recid,
		record : 'Tratamientos/get/'+recid,
		fields : [
		{ name: 'descripcionTratamiento', type: 'text',  required: true },
		{ name: 'fechaInicioTratamiento', type: 'date',  required: true },
		{ name: 'fechaFinalTratamiento', type: 'date',  required: true },
		{ name: 'pacienteTratamiento', type: 'select',  options : { url : "null", showNone : true}, required: true },
		{ name: 'finalizadoTratamiento', type: 'checkbox',  required: true }		],
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
			w2ui['listaTratamientos'].reload();
		}
	});
	$().w2popup('open', {
		title	: 'Modificar tratamiento',
		body	: '<div id="formModificarTratamiento" style="width: 100%; height: 100%; text-align:left"></div>',
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
				$('#w2ui-popup #formModificarTratamiento').w2render('formModificarTratamiento');
			}
		}
	});
}
