package ciGenerator.js;
import java.util.ArrayList;

import ciGenerator.Utils;
import ciGenerator.model.Propiedad;
import ciGenerator.ui.Pestana;


public class GenerarJs{
	

	/**
	 * Generar el js necesario para las operaciones de <nombreclase>
	 * @param nombreclase
	 * @param propiedades
	 * @return
	 */
	public static String Iniciar(String nombreClase, ArrayList<Propiedad> propiedades,ArrayList<Pestana> pestanas, boolean create, boolean edit, boolean delete){
		String output="";
		
		//Script necesario para listar <nombreClase>s
		output+=LoadScriptLista(nombreClase, propiedades, create, edit, delete);
		
		//Script necesario para crear <nombreClase>
		output+=LoadScriptNuevo(nombreClase, propiedades, pestanas);
		
		//Script necesario para modificar <nombreClase>
		output+=LoadScriptModificar(nombreClase, propiedades, pestanas);
		return output;
	}

	/**
	 * Creamos el script para las listas de la web
	 * @param nombreClase
	 * @param propiedades
	 * @return
	 */
	public static String LoadScriptLista(String nombreClase, ArrayList<Propiedad> propiedades, boolean create, boolean edit, boolean delete){
		String output="";
		
		for (Propiedad p: propiedades) {
			if(p.isEditableWeb() && !p.getTipo().isSimple()){
				output+="var lista"+Utils.ConvertirAPlurar(nombreClase)+Utils.ConvertirAPlurar(p.getNombre())+" = new Array();\n";		
			}
		}
		
		output+="var lista"+Utils.ConvertirAPlurar(nombreClase)+"Nuevos=0;\n";
		//Cargamos todas las listas de campos no simples
		output+="$(function () {\n";
				
		for (Propiedad p: propiedades) {
			if(p.isEditableWeb() && !p.getTipo().isSimple()){
		output+="$.getJSON(base_url+'"+Utils.ConvertirAPlurar(p.getNombre())+"/getEnum', function (data) {\n";
		output+="$(data.records).each(function(){\n";
		output+="	lista"+Utils.ConvertirAPlurar(nombreClase)+Utils.ConvertirAPlurar(p.getNombre())+".push({id:this.id, text:this.text});\n";			
		output+="	w2ui.lista"+Utils.ConvertirAPlurar(nombreClase)+".getColumn('"+p.getNombre()+"').editable.items = lista"+Utils.ConvertirAPlurar(nombreClase)+Utils.ConvertirAPlurar(p.getNombre().toLowerCase())+";\n";
		output+="	});\n";
		output+="});";							
			}
		}
		
		output+="});\n";
			
		
		output+="$('#lista"+nombreClase+"').w2grid({\n";
		output+="	name: 'lista"+Utils.ConvertirAPlurar(nombreClase)+"',\n";
		output+="	header: 'Lista de "+Utils.ConvertirAPlurar(nombreClase)+"',\n";
		output+="	url: {\n";
		output+="		get : '"+Utils.ConvertirAPlurar(nombreClase)+"/getListJson',\n";
		output+="		remove: '"+Utils.ConvertirAPlurar(nombreClase)+"/eliminar',\n";
		output+="		save:  '"+Utils.ConvertirAPlurar(nombreClase)+"/modificar',\n";
		output+="	},\n";
		output+="	show: {\n";
		output+="		selectColumn: true,\n";
		output+="		toolbar 	: true,\n";
		output+="		footer		: true,\n";
		output+="		lineNumbers	: true,\n";
		output+="		toolbarAdd	: "+(create ? "true": "false")+",\n";
		output+="		toolbarEdit : "+(edit ? "true": "false")+",\n";
		output+="		toolbarDelete : "+(delete ? "true": "false")+"\n";
		output+="	},\n";
		output+="	multiSearch: false,\n";
		output+="	searches:	[\n";
		for(Propiedad p : propiedades){
			String tipo = p.getTipo().GetTipoW2UI();
		
			if(p.isBusquedasPor()){
		output+="		{ field: '"+p.getNombre()+"', caption: '"+p.getLabel()+"', type: '"+tipo+"' },\n";
			}
		}
		output+="	],\n";
		output+="   columns: [\n";
		output+="		{ field: 'Id', caption:'Id', visible:false},\n";
		for(Propiedad propiedad : propiedades){
			String textoEdit = ", editable: {type: \""+propiedad.getTipo().GetTipoW2UI()+"\"}" ;
			String textoOrde = ", sortable: {type: \""+propiedad.getTipo().GetTipoW2UI()+"\"}";
			String options = "";
			String render = "";
			if(!propiedad.getTipo().isSimple()){
				render+=",render: function (record, index, col_index) {";
				render+="var html = '';";
				render+="for (var p in lista"+Utils.ConvertirAPlurar(nombreClase)+Utils.ConvertirAPlurar(propiedad.getNombre())+") {";
				render+="	if(record.changes!=undefined && record.changes."+propiedad.getNombre()+"!=undefined){";
				render+="		if (lista"+Utils.ConvertirAPlurar(nombreClase)+Utils.ConvertirAPlurar(propiedad.getNombre())+"[p].id == record.changes."+propiedad.getNombre()+") ";
				render+="			html = lista"+Utils.ConvertirAPlurar(nombreClase)+Utils.ConvertirAPlurar(propiedad.getNombre())+"[p].text;";
				render+="	}else{";		
				render+="		if (lista"+Utils.ConvertirAPlurar(nombreClase)+Utils.ConvertirAPlurar(propiedad.getNombre())+"[p].id == w2ui.lista"+Utils.ConvertirAPlurar(nombreClase)+".get(record.recid)."+propiedad.getNombre().toLowerCase()+"Id) ";
				render+="			html = lista"+Utils.ConvertirAPlurar(nombreClase)+Utils.ConvertirAPlurar(propiedad.getNombre())+"[p].text;	";
				render+="	}";
				render+="}";
				render+="	return html|| '';";
				render+="}";
				
				if(propiedad.getUrlPosiblesValores()!=null){
				options+=", options : { url : \""+propiedad.getUrlPosiblesValores()+"\"}";
				}
			}
			if(propiedad.isVisibleWeb()){
		output+="		{ field: '"+propiedad.getNombre()+"', caption: '"+propiedad.getLabel()+"', size: '30%', resizable: true "+(propiedad.isEditableWeb() ? textoEdit : "")+" "+(propiedad.isOrdenarPor() ? textoOrde:"")+" "+options+render+"},\n";
			}				
		}
		
		output+="	],\n";
		output+="	onEdit : function(event){\n";
		output+="		openPopupModificar"+nombreClase+"(event);\n";
		output+="	},\n";
		output+="	toolbar:{\n";
        output+="   	onClick: function (event) {\n";
        output+="       	if (event.target == 'w2ui-add') {\n";
        output+="				w2ui.lista"+Utils.ConvertirAPlurar(nombreClase)+".add({ recid: lista"+Utils.ConvertirAPlurar(nombreClase)+"Nuevos - 1 });\n";
        output+="				lista"+Utils.ConvertirAPlurar(nombreClase)+"Nuevos--;\n";
        output+="				w2ui.lista"+Utils.ConvertirAPlurar(nombreClase)+".total=w2ui.lista"+Utils.ConvertirAPlurar(nombreClase)+"+1;\n";
        output+="			}\n";
        output+="	    }\n";        
		output+="	}\n";
		output+="});\n\n";
		return output;
	}
	
	/**
	 * Creamos el script para poder crear objetos <nombreClase>
	 * @param nombreClase
	 * @param propiedades
	 * @param pestanas
	 * @return
	 */
	public static String LoadScriptNuevo(String nombreClase, ArrayList<Propiedad> propiedades, ArrayList<Pestana> pestanas){
		String output="";
		
		output+="$().w2form({ \n";
		output+="	name   : 'formNuevo"+nombreClase+"',\n";
		output+="	header : 'Nuevo "+nombreClase.toLowerCase()+"',\n";
		output+="	url    : '"+Utils.ConvertirAPlurar(nombreClase.toLowerCase())+"/nuevo',\n";	
		output+="	formURL: '"+Utils.ConvertirAPlurar(nombreClase.toLowerCase())+"/formNuevo',\n";	
		output+="	fields : [\n";
		for(Propiedad p : propiedades){
			String options = "";
			if(!p.getTipo().isSimple()){
				options+=" options : { url : \""+p.getUrlPosiblesValores()+"\", showNone : true},";
			}
			output+="		{ name: '"+p.getNombre()+"Nuevo"+nombreClase+"', type: '"+p.getTipo().GetTipoW2UI()+"', "+options+" required: "+(p.isRequerido() ? "true": "false")+" },\n";	
		}
		output+="	],\n";	

		output+="	tabs: [\n";
		int i = 0;
		while(i<pestanas.size()){
		output+="		{ id: 'tab"+(i+1)+"', caption: '"+pestanas.get(i).getNombre()+"' },\n";
			i++;
		}
		output+="	],\n";
		output+="	actions: {\n";	
		output+="		reset: function () {\n";
		output+="			this.clear();\n";
		output+="		},\n";
		output+="		save: function () {\n";
		output+="			this.save();\n";
		output+="		}\n";
		output+="	},\n";
		output+="	onSave : function(event){\n";
		output+="		if(event['status']==\"success\"){\n";
		output+="			this.clear();\n";
		output+="		}\n";
		output+="	}\n";
		output+="});\n";	

		return output;
	}

	public static String LoadScriptModificar(String nombreClase, ArrayList<Propiedad> propiedades, ArrayList<Pestana> pestanas){
		String output="\n";
		output+="function openPopupModificar"+nombreClase+" (event) {\n";
		output+="	var recid=event.recid;\n";
		output+="	if(w2ui['formModificar"+nombreClase+"']!=null){ w2ui['formModificar"+nombreClase+"'].destroy();}\n";
		output+="	$().w2form({\n";
		output+="		name   : 'formModificar"+nombreClase+"',\n";
		output+="			url  : {\n";
		output+="				get  : '"+Utils.ConvertirAPlurar(nombreClase)+"/get/',\n";
		output+="				save : '"+Utils.ConvertirAPlurar(nombreClase)+"/modificar'\n"; 
		output+="			},\n";
		output+="		formURL: '"+Utils.ConvertirAPlurar(nombreClase)+"/formModificar/',\n";
		output+="		recid  : recid,\n";
		output+="		record : '"+Utils.ConvertirAPlurar(nombreClase)+"/get/'+recid,\n";
		output+="		fields : [\n";
		int i = 0;
		while(i<propiedades.size()){
			Propiedad p = propiedades.get(i);
			String options = "";
			if(!p.getTipo().isSimple()){
				options+= " options : { url : \""+p.getUrlPosiblesValores()+"\", showNone : true},";
			}
		output+="		{ name: '"+p.getNombre()+nombreClase+"', type: '"+p.getTipo().GetTipoW2UI()+"', "+options+" required: "+(p.isRequerido() ? "true": "false")+" }";	
			i++;
			if(i<propiedades.size()){
				output+=",\n";
			}
		}
		output+="		],\n";
		output+="		tabs: [\n";
		i = 0;
		while(i<pestanas.size()){
		output+="			{ id: 'tab"+(i+1)+"', caption: '"+pestanas.get(i).getNombre()+"' },\n";
			i++;
		}
		output+="		],\n";
		output+="		actions: {\n";
		output+="			reset: function () {\n";
		output+="				this.clear();\n";
		output+="			},\n";
		output+="			save: function () {\n";
		output+="				this.save();\n";
		output+="			}\n";
		output+="		},\n";
		output+="		onSave: function(event){\n";
		output+="			w2ui['lista"+Utils.ConvertirAPlurar(nombreClase)+"'].reload();\n";
		output+="		}\n";
		output+="	});\n";
		
		output+="	$().w2popup('open', {\n";
		output+="		title	: 'Modificar "+nombreClase.toLowerCase()+"',\n";
		output+="		body	: '<div id=\"formModificar"+nombreClase+"\" style=\"width: 100%; height: 100%; text-align:left\"></div>',\n";
		output+="		style	: 'padding: 15px 0px 0px 0px',\n";
		output+="					width	: 800,\n";
		output+="					height	: 500, \n";
		output+="					showMax : true,\n";
		output+="		onMin	: function (event) {\n";
		output+="			$(w2ui.foo.box).hide();\n";
		output+="			event.onComplete = function () {\n";
		output+="				$(w2ui.foo.box).show();\n";		
		output+="				w2ui.foo.resize();\n";			
		output+="			}\n";			
		output+="		},\n";
		output+="		onMax	: function (event) {\n";
		output+="			$(w2ui.foo.box).hide();\n";
		output+="			event.onComplete = function () {\n";
		output+="				$(w2ui.foo.box).show();\n";
		output+="				w2ui.foo.resize();\n";
		output+="			}\n";
		output+="		},\n";
		output+="		onOpen	: function (event) {\n";
		output+="			event.onComplete = function () {\n";	
		output+="				$('#w2ui-popup #formModificar"+nombreClase+"').w2render('formModificar"+nombreClase+"');\n";
		output+="			}\n";
		output+="		}\n";
		output+="	});\n";
		output+="}\n";
		return output;
	}
}
