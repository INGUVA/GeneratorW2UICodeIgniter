var listaFicherospacientes = new Array();
var listaFicherosNuevos=0;
$(function () {
$.getJSON(base_url+'pacientes/getEnum', function (data) {
$(data.records).each(function(){
	listaFicherospacientes.push({id:this.id, text:this.text});
	w2ui.listaFicheros.getColumn('paciente').editable.items = listaFicherospacientes;
	});
});});
$('#listaFichero').w2grid({
	name: 'listaFicheros',
	header: 'Lista de Ficheros',
	url: {
		get : 'Ficheros/getListJson',
		remove: 'Ficheros/eliminar',
		save:  'Ficheros/modificar',
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
		{ field: 'paciente', caption: 'Paciente', size: '30%', resizable: true , editable: {type: "select"}  ,render: function (record, index, col_index) {var html = '';for (var p in listaFicherospacientes) {	if(record.changes!=undefined && record.changes.paciente!=undefined){		if (listaFicherospacientes[p].id == record.changes.paciente) 			html = listaFicherospacientes[p].text;	}else{		if (listaFicherospacientes[p].id == w2ui.listaFicheros.get(record.recid).pacienteId) 			html = listaFicherospacientes[p].text;		}}	return html|| '';}},
	],
	onEdit : function(event){
		openPopupModificarFichero(event);
	},
	toolbar:{
   	onClick: function (event) {
       	if (event.target == 'w2ui-add') {
				w2ui.listaFicheros.add({ recid: listaFicherosNuevos - 1 });
				listaFicherosNuevos--;
				w2ui.listaFicheros.total=w2ui.listaFicheros+1;
			}
	    }
	}
});

$().w2form({ 
	name   : 'formNuevoFichero',
	header : 'Nuevo fichero',
	url    : 'ficheros/nuevo',
	formURL: 'ficheros/formNuevo',
	fields : [
		{ name: 'nombreNuevoFichero', type: 'text',  required: true },
		{ name: 'fechaCapturaNuevoFichero', type: 'date',  required: true },
		{ name: 'rutaNuevoFichero', type: 'text',  required: true },
		{ name: 'pacienteNuevoFichero', type: 'select',  options : { url : "null", showNone : true}, required: true },
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

function openPopupModificarFichero (event) {
	var recid=event.recid;
	if(w2ui['formModificarFichero']!=null){ w2ui['formModificarFichero'].destroy();}
	$().w2form({
		name   : 'formModificarFichero',
			url  : {
				get  : 'Ficheros/get/',
				save : 'Ficheros/modificar'
			},
		formURL: 'Ficheros/formModificar/',
		recid  : recid,
		record : 'Ficheros/get/'+recid,
		fields : [
		{ name: 'nombreFichero', type: 'text',  required: true },
		{ name: 'fechaCapturaFichero', type: 'date',  required: true },
		{ name: 'rutaFichero', type: 'text',  required: true },
		{ name: 'pacienteFichero', type: 'select',  options : { url : "null", showNone : true}, required: true }		],
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
			w2ui['listaFicheros'].reload();
		}
	});
	$().w2popup('open', {
		title	: 'Modificar fichero',
		body	: '<div id="formModificarFichero" style="width: 100%; height: 100%; text-align:left"></div>',
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
				$('#w2ui-popup #formModificarFichero').w2render('formModificarFichero');
			}
		}
	});
}
