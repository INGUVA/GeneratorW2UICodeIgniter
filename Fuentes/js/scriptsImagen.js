var listaImagenespacientes = new Array();
var listaImagenesNuevos=0;
$(function () {
$.getJSON(base_url+'pacientes/getEnum', function (data) {
$(data.records).each(function(){
	listaImagenespacientes.push({id:this.id, text:this.text});
	w2ui.listaImagenes.getColumn('paciente').editable.items = listaImagenespacientes;
	});
});});
$('#listaImagen').w2grid({
	name: 'listaImagenes',
	header: 'Lista de Imagenes',
	url: {
		get : 'Imagenes/getListJson',
		remove: 'Imagenes/eliminar',
		save:  'Imagenes/modificar',
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
		{ field: 'fechaCaptura', caption: 'Fecha de captura', type: 'date' },
		{ field: 'ruta', caption: 'Imagen', type: 'text' },
		{ field: 'paciente', caption: 'Paciente', type: 'select' },
	],
   columns: [
		{ field: 'Id', caption:'Id', visible:false},
		{ field: 'nombre', caption: 'Nombre', size: '30%', resizable: true , editable: {type: "text"} , sortable: {type: "text"} },
		{ field: 'fechaCaptura', caption: 'Fecha de captura', size: '30%', resizable: true , editable: {type: "date"} , sortable: {type: "date"} },
		{ field: 'ruta', caption: 'Imagen', size: '30%', resizable: true , editable: {type: "text"} , sortable: {type: "text"} },
		{ field: 'paciente', caption: 'Paciente', size: '30%', resizable: true , editable: {type: "select"}  ,render: function (record, index, col_index) {var html = '';for (var p in listaImagenespacientes) {	if(record.changes!=undefined && record.changes.paciente!=undefined){		if (listaImagenespacientes[p].id == record.changes.paciente) 			html = listaImagenespacientes[p].text;	}else{		if (listaImagenespacientes[p].id == w2ui.listaImagenes.get(record.recid).pacienteId) 			html = listaImagenespacientes[p].text;		}}	return html|| '';}},
	],
	onEdit : function(event){
		openPopupModificarImagen(event);
	},
	toolbar:{
   	onClick: function (event) {
       	if (event.target == 'w2ui-add') {
				w2ui.listaImagenes.add({ recid: listaImagenesNuevos - 1 });
				listaImagenesNuevos--;
				w2ui.listaImagenes.total=w2ui.listaImagenes+1;
			}
	    }
	}
});

$().w2form({ 
	name   : 'formNuevoImagen',
	header : 'Nuevo imagen',
	url    : 'imagenes/nuevo',
	formURL: 'imagenes/formNuevo',
	fields : [
		{ name: 'nombreNuevoImagen', type: 'text',  required: true },
		{ name: 'fechaCapturaNuevoImagen', type: 'date',  required: true },
		{ name: 'rutaNuevoImagen', type: 'text',  required: true },
		{ name: 'pacienteNuevoImagen', type: 'select',  options : { url : "null", showNone : true}, required: true },
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

function openPopupModificarImagen (event) {
	var recid=event.recid;
	if(w2ui['formModificarImagen']!=null){ w2ui['formModificarImagen'].destroy();}
	$().w2form({
		name   : 'formModificarImagen',
			url  : {
				get  : 'Imagenes/get/',
				save : 'Imagenes/modificar'
			},
		formURL: 'Imagenes/formModificar/',
		recid  : recid,
		record : 'Imagenes/get/'+recid,
		fields : [
		{ name: 'nombreImagen', type: 'text',  required: true },
		{ name: 'fechaCapturaImagen', type: 'date',  required: true },
		{ name: 'rutaImagen', type: 'text',  required: true },
		{ name: 'pacienteImagen', type: 'select',  options : { url : "null", showNone : true}, required: true }		],
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
			w2ui['listaImagenes'].reload();
		}
	});
	$().w2popup('open', {
		title	: 'Modificar imagen',
		body	: '<div id="formModificarImagen" style="width: 100%; height: 100%; text-align:left"></div>',
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
				$('#w2ui-popup #formModificarImagen').w2render('formModificarImagen');
			}
		}
	});
}
