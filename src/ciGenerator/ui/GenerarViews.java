package ciGenerator.ui;
import java.util.ArrayList;

import ciGenerator.model.Propiedad;
import ciGenerator.model.tipos.Boolean;
import ciGenerator.model.tipos.Date;
import ciGenerator.model.tipos.List;


public class GenerarViews {

	/**
	 * Creamos el json para las listas de la web
	 * @param args
	 */
	public static String LoadViewListJson(String nombreClase, ArrayList<Propiedad> propiedades) {
		String output="";
		
		output+="<?php\n";
		output+="	$this->load->helper('date')\n;";
		output+="    echo '{\n";
		output+="			\"total\": '.count($lista"+nombreClase+").',\n";
		output+="			\"records\":  [';\n";
		output+="			$i=1;\n";
		output+="			if(count($lista"+nombreClase+")>0){\n";
		output+="				foreach($lista"+nombreClase+" as $"+nombreClase.toLowerCase()+"){\n";
		output+="					echo ' { \"recid\": '.$"+nombreClase.toLowerCase()+"['Id'].', \n";
		int i = 0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
			if(propiedad.isVisibleWeb()){
				String letraInicial = propiedad.getNombre().substring(0, 1).toUpperCase();
				String nombreFunction = propiedad.getNombre().replaceFirst(propiedad.getNombre().substring(0, 1), letraInicial);
				if(propiedad.getTipo().isSimple()){
					if(propiedad.getTipo() instanceof Boolean){
			output+="                    \""+propiedad.getNombre()+"\": \"';if($"+nombreClase.toLowerCase()+"['"+propiedad.getNombre()+"']){echo \"Si\";}else{echo \"No\";}echo '\"";	
					}else if(propiedad.getTipo() instanceof Date){
			output+="                    \""+propiedad.getNombre()+"\": \"'.mysql_to_w2ui($"+nombreClase.toLowerCase()+"[\""+propiedad.getNombre()+"\"]).'\"";	
					}else{
			output+="                    \""+propiedad.getNombre()+"\": \"'.$"+nombreClase.toLowerCase()+"['"+propiedad.getNombre()+"'].'\"";						
					}
				}else{
			output+="                    \""+propiedad.getNombre()+"Id\": '.$"+nombreClase.toLowerCase()+"['"+propiedad.getNombre()+"Id'].',\n";
			output+="                    \""+propiedad.getNombre()+"Nombre\": \"'.$"+nombreClase.toLowerCase()+"['"+propiedad.getNombre()+"Nombre'].'\"\n";
				}
			if(i<propiedades.size()-1){
				output+=",\n";
			}
			
			}
			i++;
		}
		output+="';\n";
		output+="               	$i++;\n";
		output+="               	if($i>count($lista"+nombreClase+")){\n";
		output+="                   	echo '	}';\n";
		output+="               	}else{\n";
		output+="                   	echo '	},';\n";
		output+="               	}\n";
		output+="               }\n";
		output+="           }\n";
		output+=" echo '     ]\n";
		output+="    }';\n";
		output+="?>";
		return output;
	}
	
	/**
	 * Creamos el json para las listas de la web
	 * @param args
	 */
	public static String LoadViewListEnum(String nombreClase, ArrayList<Propiedad> propiedades) {
		String output="";
		
		output+="<?php\n";
		
		output+="    echo '{\n";
		output+="			\"total\": '.count($lista"+nombreClase+").',\n";
		output+="			\"records\":  [';\n";
		output+="			$i=1;\n";
		output+="			if(count($lista"+nombreClase+")>0){\n";
		output+="				foreach($lista"+nombreClase+" as $"+nombreClase.toLowerCase()+"){\n";
		output+="					echo ' { \"id\": '.$"+nombreClase.toLowerCase()+"['Id'].', \n";
		int i = 0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
			if(propiedad.isMostrar()){
				output+="                    \"text\": \"'.$"+nombreClase.toLowerCase()+"['"+propiedad.getNombre()+"'].'\"";
			}
			i++;
		}
		output+="';\n";
		output+="               	$i++;\n";
		output+="               	if($i>count($lista"+nombreClase+")){\n";
		output+="                   	echo '	}';\n";
		output+="               	}else{\n";
		output+="                   	echo '	},';\n";
		output+="               	}\n";
		output+="               }\n";
		output+="           }\n";
		output+=" echo '     ]\n";
		output+="    }';\n";
		output+="?>";
		return output;
	}

	public static String LoadViewJson(String nombreClase, ArrayList<Propiedad> propiedades){
		String output="";
		
		output+="<?php\n";
		output+="	$this->load->helper('date')\n;";
		output+="    echo '{\n";
		output+="          status: \"success\",\n";
		output+="          record:  ';\n";
		output+="               echo ' { \"recid\": '.$"+nombreClase.toLowerCase()+"->getId().', \n";
		int i = 0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
				String letraInicial = propiedad.getNombre().substring(0, 1).toUpperCase();
				String nombreFunction = propiedad.getNombre().replaceFirst(propiedad.getNombre().substring(0, 1), letraInicial);
				if(propiedad.getTipo().isSimple()){
					if(propiedad.getTipo() instanceof Boolean){
				output+="                    \""+propiedad.getNombre()+"\": \"';if($"+nombreClase.toLowerCase()+"['"+propiedad.getNombre()+"']){echo \"Si\";}else{echo \"No\";}echo '\"";	
					}else if(propiedad.getTipo() instanceof Date){
				output+="                    \""+propiedad.getNombre()+"\": \"'.mysql_to_w2ui($"+nombreClase.toLowerCase()+"[\""+propiedad.getNombre()+"\"]).'\"";
					}else{
				output+="                    \""+propiedad.getNombre()+"\": \"'.$"+nombreClase.toLowerCase()+"['"+propiedad.getNombre()+"'].'\"";						
					}
				}else{
				output+="                    \""+propiedad.getNombre()+"Id\": '.$"+nombreClase.toLowerCase()+"['"+propiedad.getNombre()+"Id'].',\n";
				output+="                    \""+propiedad.getNombre()+"Nombre\": \"'.$"+nombreClase.toLowerCase()+"['"+propiedad.getNombre()+"Nombre'].'\"";					
				}
			if(i<propiedades.size()-1){
				output+=",\n";
			}
			
			i++;
		}
		output+="';\n";
		output+=" echo '     		}\n";
		output+="     }';\n";
		output+="?>";
		return output;
	}
	
	
	
	/**
	 * Crea la vista que devuelve el resultado de la eliminación de registros.
	 * @return
	 */
	public static String LoadViewVistaDeleteResult(){
		String	output="<?php\n";
		output+="/*\n";
		output+=" * Esta vista recoge como resultado un ActionConfirmation\n";
		output+=" * - Success: true Indica que la operación se realizó correctamente.\n";
		output+=" * - Success: false Indica que hubo algún error, indicandolo en el mensaje.\n";
		output+=" */\n";
		
		output+=" if($resultado->isCorrecto()){\n";
		output+=" 	echo '{\"status\": \"success\"}';\n";
		output+=" }else{\n";
		output+="	echo '{\"status\": \"error\", \"message\": \"'.$resultado->getMensaje().'\"}';\n";
		output+=" }\n";
		
		output+="?>";
		return output;
		
	}

	/**
	 * Cargar la vista de la creación de un nuevo establecimiento
	 * @param nombreClase
	 * @param propiedades
	 * @return
	 */
	public static String LoadViewVistaFormNuevo(String nombreClase,ArrayList<Propiedad> propiedades, ArrayList<Pestana> pestanas){
		String output="";
		int indicePestana = 0;
		Pestana pestana=null;
		if(pestanas.size()>0)
			pestana= pestanas.get(indicePestana);
		
		output+="	<div id=\"formNuevo"+nombreClase+"\">\n";
		if(pestanas.size()>0)
		output+="		<div class=\"w2ui-page page-0\">\n";
		int camposEnPestana = 0;
		for(Propiedad p : propiedades){
			if(pestanas.size()>0 &&	camposEnPestana>=pestana.getNumeroCampos()){
		indicePestana++;
		output+="		</div>\n";
		output+="		<div class=\"w2ui-page page-"+indicePestana+"\">\n";
			camposEnPestana = 0;
			pestana = pestanas.get(indicePestana);
			}
		output+="			<div class=\"w2ui-label\">"+p.getLabel()+":</div>\n";
		output+="			<div class=\"w2ui-field\">\n";
		if(p.getTipo() instanceof List){
			output+="				<select name=\""+p.getNombre()+"Nuevo"+nombreClase+"\"/></select>\n";			
		}else{
			String title = ((p.getHtmlPlaceHolder()!=null && p.getHtmlTitle()!="")  ? " title=\""+String.valueOf(p.getHtmlTitle())+"\"" :"");;
			String placeholder = ((p.getHtmlPlaceHolder()!=null && p.getHtmlPlaceHolder()!="")  ? " placeholder=\""+ String.valueOf(p.getHtmlPlaceHolder())+"\"" :"");
			String maxlength = (p.getHtmlMaxLenght()>0  ? " maxlength=\""+String.valueOf(p.getHtmlMaxLenght()+"\"") :"");
			String size = " size=\""+(p.getHtmlSize()>0  ? p.getHtmlSize() :60)+"\"";
			output+="				<input name=\""+p.getNombre()+"Nuevo"+nombreClase+"\" type=\""+p.getTipo().GetInputW2UI()+"\" "+title+placeholder+maxlength+size+"/>\n";			
		}

		output+="			</div>\n";
		camposEnPestana++;
		}
		if(pestanas.size()>0)
		output+="		</div>\n";
		output+="		<div class=\"w2ui-buttons\">\n";
		output+="			<input type=\"button\" value=\"Borrar\" name=\"reset\">\n";
		output+="			<input type=\"button\" value=\"Guardar\" name=\"save\">\n";
		output+="		</div>\n";
		output+="	</div>\n";
		return output;
	}
	
	/**
	 * Cargar la vista de la creación de un nuevo establecimiento
	 * @param nombreClase
	 * @param propiedades
	 * @return
	 */
	public static String LoadViewVistaFormUpdate(String nombreClase,ArrayList<Propiedad> propiedades, ArrayList<Pestana> pestanas){
		String output="";
		int indicePestana = 0;
		Pestana pestana=null;
		if(pestanas.size()>0)
			pestana= pestanas.get(indicePestana);
		
		output+="	<div id=\"formUpdate"+nombreClase+"\">\n";
		if(pestanas.size()>0)
		output+="		<div class=\"w2ui-page page-0\">\n";
		int camposEnPestana = 0;
		for(Propiedad p : propiedades){
			if(pestanas.size()>0 &&	camposEnPestana>=pestana.getNumeroCampos()){
		indicePestana++;
		output+="		</div>\n";
		output+="		<div class=\"w2ui-page page-"+indicePestana+"\">\n";
			camposEnPestana = 0;
			pestana = pestanas.get(indicePestana);
			}
		output+="			<div class=\"w2ui-label\">"+p.getLabel()+":</div>\n";
		output+="			<div class=\"w2ui-field\">\n";
		if(p.getTipo() instanceof List){
			output+="				<select name=\""+p.getNombre()+nombreClase+"\"/></select>\n";			
		}else{
			String title = ((p.getHtmlPlaceHolder()!=null && p.getHtmlTitle()!="")  ? " title=\""+String.valueOf(p.getHtmlTitle())+"\"" :"");;
			String placeholder = ((p.getHtmlPlaceHolder()!=null && p.getHtmlPlaceHolder()!="")  ? " placeholder=\""+ String.valueOf(p.getHtmlPlaceHolder())+"\"" :"");
			String maxlength = (p.getHtmlMaxLenght()>0  ? " maxlength=\""+String.valueOf(p.getHtmlMaxLenght()+"\"") :"");
			output+="				<input name=\""+p.getNombre()+nombreClase+"\" type=\""+p.getTipo().GetInputW2UI()+"\" size=\""+((p.getTipo() instanceof Date) ? "10":"60")+"\" "+title+placeholder+maxlength+"/>\n";			
		}

		output+="			</div>\n";
		camposEnPestana++;
		}
		if(pestanas.size()>0)
		output+="		</div>\n";
		output+="		<div class=\"w2ui-buttons\">\n";
		output+="			<input type=\"button\" value=\"Borrar\" name=\"reset\">\n";
		output+="			<input type=\"button\" value=\"Guardar\" name=\"save\">\n";
		output+="		</div>\n";
		output+="	</div>\n";
		return output;
	}
	

	/**
	 * Crea la vista que devuelve el resultado de la creación de un registro.
	 * @return
	 */
	public static String LoadViewVistaNewResult(){
		String	output="<?php\n";
		output+="/*\n";
		output+=" * Esta vista recoge como resultado un ActionConfirmation\n";
		output+=" * - Success: true Indica que la operación se realizó correctamente.\n";
		output+=" * - Success: false Indica que hubo algún error, indicandolo en el mensaje.\n";
		output+=" */\n";
		
		output+=" header('Content-Type: application/json; charset=ISO-8859-1');";
		output+=" if($resultado->isCorrecto()){\n";
		output+=" 	 	echo '{\"status\": \"success\",\"message\": '.json_encode(str_replace(\"\\n\", \"<br/>\", $resultado->getMensaje())).'}';\n";
		output+=" }else{\n";
		output+=" 	 	echo '{\"status\": \"error\",\"message\": '.json_encode(str_replace(\"\\n\", \"<br/>\", $resultado->getMensaje())).'}';\n";
		output+=" }\n";
		
		output+="?>";
		return output;
		
	}
	
	/**
	 * Crea la vista que devuelve el resultado de la creación de un registro.
	 * @return
	 */
	public static String LoadViewVistaUpdateResult(){
		String	output="<?php\n";
		output+="/*\n";
		output+=" * Esta vista recoge como resultado un ActionConfirmation\n";
		output+=" * - Success: true Indica que la operación se realizó correctamente.\n";
		output+=" * - Success: false Indica que hubo algún error, indicandolo en el mensaje.\n";
		output+=" */\n";
		
		output+=" if($resultado->isCorrecto()){\n";
		output+=" 	echo '{\"status\": \"success\"}';\n";
		output+=" }else{\n";
		output+="	echo '{\"status\": \"error\", \"message\": \"'.$resultado->getMensaje().'\"}';\n";
		output+=" }\n";
		
		output+="?>";
		return output;
		
	}
}
