package ciGenerator.library;
import java.util.ArrayList;

import ciGenerator.model.Propiedad;


public class GenerarService {

	/**
	 * @param args
	 */
	public static String Iniciar(String nombreClase,ArrayList<Propiedad> propiedades) {
		String output = "";
		
		output+="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
		output+="\n";
		output+="class Service"+nombreClase+"{\n";
		output+="    private $CI;";
		
		//Creación del constructor
		output+= GenerarConstructor();
		
		//Creación del nuevo
		output+=GenerarNuevo(nombreClase,propiedades);
		
		//Creaccion de la modificacion
		output+=GenerarModificar(nombreClase, propiedades);
		
		//Creación de eliminacion
		output+=GenerarEliminar(nombreClase);
		
		//Creación del GetById
		output+=GenerarGetById(nombreClase);
		
		//Creacion de obtener lista
		output+=GenerarGetAll(nombreClase);
		output+="};";
		
		return output;
	}
	
	private static String GenerarConstructor(){
		String output="\n";
		
		output+="    public function __construct(){\n";
		output+="          $this->CI =& get_instance();\n";
		output+="    }\n";
		
		return output;
	}
	
	private static String GenerarNuevo(String nombreClase, ArrayList<Propiedad> propiedades){
		String output="\n";
		
		output+="      function Nuevo(";
		int i = 0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
			output+="$_"+propiedad.getNombre();
			i++;
			if(i<propiedades.size()){
				output+=",";
			}
			
		}
		output+="){\n";
	
		output+="          $obj= $this->CI->"+nombreClase.toLowerCase()+"->Nuevo(";
		i = 0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
			output+="$_"+propiedad.getNombre();
			i++;
			if(i<propiedades.size()){
				output+=",";
			}
			
		}
		output+=");\n";
		
		output+="         if($obj!=null){\n";
		output+="              return Actionconfirmation::CreateSuccessActionConfirmation(\"OK\", $obj);\n";
		output+="         }else{\n";
		output+="              return Actionconfirmation::CreateFailureActionConfirmation(\"ERROR\", null);\n";	
		output+="         };\n";		
		output+="     }\n";
		return output;
	}

	private static String GenerarGetById(String nombreClase){
		String output="\n";
		
		output+="    public function Get"+nombreClase+"ById($id){\n";
		output+="         $obj = $this->CI->"+nombreClase.toLowerCase()+"->get"+nombreClase+"ById($id);\n";
		output+="         if($obj==null){\n";
		output+="              return Actionconfirmation::CreateFailureActionConfirmation(\"ERROR\", null);\n";
		output+="         }else{\n";
		output+="              return Actionconfirmation::CreateSuccessActionConfirmation(\"OK\", $obj);\n";
		output+="         }\n";
		output+="    }\n";
		
		return output;
	}
	
	private static String GenerarModificar(String nombreClase,ArrayList<Propiedad> propiedades){
		String output="\n";
		
		output+="    public function Modificar($_id,";
		int i = 0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
			output+="$_"+propiedad.getNombre();
			i++;
			if(i<propiedades.size()){
				output+=",";
			}
			
		}
		output+=" ){\n";
		output+="          $obj= $this->CI->"+nombreClase.toLowerCase()+"->update($_id,";
		i = 0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
			output+="$_"+propiedad.getNombre();
			i++;
			if(i<propiedades.size()){
				output+=",";
			}
			
		}
		output+=");\n";
		
		output+="         if($obj!=null){\n";
		output+="              return Actionconfirmation::CreateSuccessActionConfirmation(\"OK\", $obj);\n";
		output+="         }else{\n";
		output+="              return Actionconfirmation::CreateFailureActionConfirmation(\"ERROR\", null);\n";	
		output+="         };\n";
		
		output+="    }\n";
		return output;
	}
	
	private static String GenerarGetAll(String nombreClase){
		String output="\n";
		
		output+="    public function GetAll($limit=100, $offset=0, $campo='Id', $order='asc', $field='', $busqueda=''){\n";
		output+="         $objs = $this->CI->"+nombreClase.toLowerCase()+"->getAll($limit, $offset, $campo, $order,$field, $busqueda);\n";
		output+="         if($objs==null || $objs==\"\"){\n";
		output+="              return Actionconfirmation::CreateFailureActionConfirmation(\"\", null);\n";
		output+="         }else{\n";
		output+="              return Actionconfirmation::CreateSuccessActionConfirmation(\"\", $objs);\n";
		output+="         }\n";
		output+="    }\n";
		
		return output;
	}
	
	private static String GenerarEliminar(String nombreClase){
		String output="\n";
		
		output+="    public function EliminarById($id){\n";
		output+="         $obj = $this->CI->"+nombreClase.toLowerCase()+"->eliminarById($id);\n";
		output+="         if($obj==null){\n";
		output+="              return Actionconfirmation::CreateFailureActionConfirmation(\"ERROR\", null);\n";
		output+="         }else{\n";
		output+="              return Actionconfirmation::CreateSuccessActionConfirmation(\"OK\", $obj);\n";
		output+="         }\n";
		output+="    }\n";
		
		return output;
	}
	
}
