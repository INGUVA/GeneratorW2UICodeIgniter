var listaVideospacientes = new Array();
var listaVideosNuevos=0;
$(function () {
$.getJSON(base_url+'pacientes/getEnum', function (data) {
$(data.records).each(function(){
	listaVideospacientes.push({id:this.id, text:this.text});
	w2ui.listaVideos.getColumn('paciente').editable.items = listaVideospacientes;
	});
});});
$('#listaVideo').w2grid({
	name: 'listaVideos',
	header: 'Lista de Videos',
	url: {
		get : 'Videos/getListJson',
		remove: 'Videos/eliminar',
		save:  'Videos/modificar',
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
		{ field: 'ruta', caption: 'Video', type: 'text' },
		{ field: 'paciente', caption: 'Paciente', type: 'select' },
	],
   columns: [
		{ field: 'Id', caption:'Id', visible:false},
		{ field: 'nombre', caption: 'Nombre', size: '30%', resizable: true , editable: {type: "text"} , sortable: {type: "text"} },
		{ field: 'fechaCaptura', caption: 'Fecha de captura', size: '30%', resizable: true , editable: {type: "date"} , sortable: {type: "date"} },
		{ field: 'ruta', caption: 'Video', size: '30%', resizable: true , editable: {type: "text"} , sortable: {type: "text"} },
		{ field: 'paciente', caption: 'Paciente', size: '30%', resizable: true , editable: {type: "select"}  ,render: function (record, index, col_index) {var html = '';for (var p in listaVideospacientes) {	if(record.changes!=undefined && record.changes.paciente!=undefined){		if (listaVideospacientes[p].id == record.changes.paciente) 			html = listaVideospacientes[p].text;	}else{		if (listaVideospacientes[p].id == w2ui.listaVideos.get(record.recid).pacienteId) 			html = listaVideospacientes[p].text;		}}	return html|| '';}},
	],
	onEdit : function(event){
		openPopupModificarVideo(event);
	},
	toolbar:{
   	onClick: function (event) {
       	if (event.target == 'w2ui-add') {
				w2ui.listaVideos.add({ recid: listaVideosNuevos - 1 });
				listaVideosNuevos--;
				w2ui.listaVideos.total=w2ui.listaVideos+1;
			}
	    }
	}
});

$().w2form({ 
	name   : 'formNuevoVideo',
	header : 'Nuevo video',
	url    : 'videos/nuevo',
	formURL: 'videos/formNuevo',
	fields : [
		{ name: 'nombreNuevoVideo', type: 'text',  required: true },
		{ name: 'fechaCapturaNuevoVideo', type: 'date',  required: true },
		{ name: 'rutaNuevoVideo', type: 'text',  required: true },
		{ name: 'pacienteNuevoVideo', type: 'select',  options : { url : "null", showNone : true}, required: true },
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

function openPopupModificarVideo (event) {
	var recid=event.recid;
	if(w2ui['formModificarVideo']!=null){ w2ui['formModificarVideo'].destroy();}
	$().w2form({
		name   : 'formModificarVideo',
			url  : {
				get  : 'Videos/get/',
				save : 'Videos/modificar'
			},
		formURL: 'Videos/formModificar/',
		recid  : recid,
		record : 'Videos/get/'+recid,
		fields : [
		{ name: 'nombreVideo', type: 'text',  required: true },
		{ name: 'fechaCapturaVideo', type: 'date',  required: true },
		{ name: 'rutaVideo', type: 'text',  required: true },
		{ name: 'pacienteVideo', type: 'select',  options : { url : "null", showNone : true}, required: true }		],
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
			w2ui['listaVideos'].reload();
		}
	});
	$().w2popup('open', {
		title	: 'Modificar video',
		body	: '<div id="formModificarVideo" style="width: 100%; height: 100%; text-align:left"></div>',
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
				$('#w2ui-popup #formModificarVideo').w2render('formModificarVideo');
			}
		}
	});
}
