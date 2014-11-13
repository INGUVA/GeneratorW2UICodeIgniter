package ciGenerator.model;
import java.util.ArrayList;

import ciGenerator.model.tipos.Boolean;
import ciGenerator.model.tipos.Date;
import ciGenerator.model.tipos.TipoDatos;



public class GenerarModelo {

	/**
	 * @param args
	 */
	public static String Iniciar(String nombreClase, ArrayList<Propiedad> propiedades) {
		String output="";
		
		output+="<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n\n";
		output+="   class "+nombreClase+" extends CI_Model {\n";
		output+="	\n";
		
		output+="	   const  id=\"Id\";\n";
		
		//Declaracion de variables
		for(Propiedad propiedad: propiedades){
			if(!propiedad.getTipo().isSimple()){
				output+="	const	"+propiedad.getNombre()+"Id = \""+propiedad.getNombre()+"Id\";\n";
				output+="	const	"+propiedad.getNombre()+"Nombre = \""+propiedad.getNombre()+"Nombre\";\n";
			}else{
				output+="      const  "+propiedad.getNombre()+"=\""+propiedad.getNombre()+"\";\n";
			}
		}
		
		//Generacion del constructor
		output+=GenerarConstructor();
		
		//Generacion de los get y los set
		//output+=GenerarGetAndSet(propiedades);
		
		//Generacion de la obtencion de base de datos por id
		output+=GenerarGetValoresRow(nombreClase, propiedades);
		output+=GenerarSetValoresRow(nombreClase, propiedades);
		
		//Generacion de la consultas a la base de datos
		output+=GenerarGetById(nombreClase);
		
		//Generacion nuevo
		output+=GenerarNuevo(nombreClase, propiedades);
		//Generacion update
		output+=GenerarUpdate(nombreClase, propiedades);
		
		//Generacion eliminacion
		output+=GenerarEliminarById(nombreClase);

		//Generacion de all
		output+=GenerarGetAll(nombreClase, propiedades);
		
		//Generación de una funcion que me devuelve la columna de campos por los que se puede ordenar
		output+=GenerarGetNameColumn(nombreClase,propiedades);
		
		output+="   }\n";
		output+="?>\n";
		return output;
			
	}
	
	/**
	 * Generación del constructor de la clase
	 * @return
	 */
	private static String GenerarConstructor(){
		/*
		 * 	function __construct(){
				// Call the Model constructor
				parent::__construct();
				$this->farmacias = array();
				$this->guardias = array();
			}
		 * 
		 */
		String output= "";
		output+="\n";
		output+="      function __construct(){\n";
		output+="         parent::__construct();\n";
		output+="      }\n";
		return output;
	}

	private static String GenerarGetAndSet(ArrayList<Propiedad> propiedades){
		String output="";
		
		output+="      function getId(){\n";
		output+="          return $this->id;\n";
		output+="      }\n\n";
		output+="      function setId($_id){\n";
		output+="          $this->id = $_id;\n";
		output+="      }\n\n";
		for(Propiedad propiedad: propiedades){
			String letraInicial = propiedad.getNombre().substring(0, 1).toUpperCase();
			String nombreFunction = propiedad.getNombre().replaceFirst(propiedad.getNombre().substring(0, 1), letraInicial);		
			if(propiedad.getTipo() instanceof Boolean){
		output+="      function is"+nombreFunction+"(){\n";
		output+="          return $this->"+propiedad.getNombre()+";\n";
		output+="      }\n";
			}else{
		output+="      function get"+nombreFunction+"(){\n";
		output+="          return $this->"+propiedad.getNombre()+";\n";
		output+="      }\n";				
			}
		
		output+="\n";
		
		output+="      function set"+nombreFunction+"($_"+propiedad.getNombre()+"){\n";
		output+="          $this->"+propiedad.getNombre()+"=$_"+propiedad.getNombre()+";\n";
		output+="      }\n";
		
		}
		
		return output;
	}

	
	
	/**
	 * Creación de la función que obtiene un elemento en base a su id
	 * @param nombreClase
	 * @return
	 */
	private static String GenerarGetById(String nombreClase){
		String output="\n";

		output+="      function get"+nombreClase+"ById($id){\n";
		output+="           $this->SetValoresRow();\n";
		output+="           $this->db->where($this->config->item('database_"+nombreClase.toLowerCase()+"_Id'),$id);\n";
		output+="           $this->db->from($this->config->item('database_"+nombreClase.toLowerCase()+"_Vista'));\n";
		output+="           $query = $this->db->get();\n";
		output+="           if($query!=false && $query->num_rows()>0){\n";
		output+="               foreach($query->result_array() as $row){\n";
		output+="                     return $this->GetValoresRow($row);\n";
		output+="               }\n";
		output+="           }else{\n";
		output+="               return null;\n";
		output+="           }\n";
		output+="      }\n";
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
	
		output+="           $data = array(\n";
		i = 0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
		output+="                 $this->config->item('database_"+nombreClase.toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"')=>$_"+propiedad.getNombre();
		
			i++;
			if(i<propiedades.size()){
				output+=",\n";
			}else{
				output+="\n";
			}
		}
		output+="           );\n";
		output+="           $con = $this->db->insert($this->config->item('database_"+nombreClase.toLowerCase()+"_Tabla'),$data);\n";
		output+="           if($con){\n";
		output+="               return $this->db->insert_id();\n";
		output+="           }else{\n";
		output+="               return -1;\n";
		output+="           }\n";

		output+="      }\n";
		
		return output;
	}
	
	private static String GenerarUpdate(String nombreClase, ArrayList<Propiedad> propiedades){
		String output="\n";
		
		output+="     function update($_id,";
		
		int i = 0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
		output+="$_"+propiedad.getNombre();
			//output+="         $this->config->item('database_"+nombreClase+"_"+propiedad.getNombreBaseDatos();
			i++;
			if(i<propiedades.size()){
				output+=",";
			}
		}
		output+="){\n";
		output+="         $data = array(\n";
		i=0;
		while(i<propiedades.size()){
			Propiedad propiedad = propiedades.get(i);
			output+="            $this->config->item('database_"+nombreClase.toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"')=>$_"+propiedad.getNombre();
			i++;
			if(i<propiedades.size()){
				output+=",\n";
			}else{
				output+="\n";
			}
		}
		output+="         );\n";
		output+="         $this->db->where($this->config->item('database_"+nombreClase.toLowerCase()+"_Id'), $_id);\n";
		output+="         $query = $this->db->update($this->config->item('database_"+nombreClase.toLowerCase()+"_Tabla'), $data);\n";
		output+="         if($query){\n";
		output+="              return true;\n";
		output+="         }else{\n";
		output+="              return false;\n";
		output+="         }\n";		
		output+="     }\n";
		
		return output;
	}
	
	private static String GenerarEliminarById(String nombreClase){
		String output="\n";
		output+="     function eliminarById($ids){\n";
		output+="		$i=0;\n";
		output+="		$clausulas=0;\n";
		output+="		foreach($ids as $id){\n";
		output+="			if($id>0){\n";
		output+="				if($i==0){\n";
		output+="           		$this->db->where($this->config->item('database_"+nombreClase.toLowerCase()+"_Id'),$id);\n";		
		output+="				}else{\n";
		output+="           		$this->db->or_where($this->config->item('database_"+nombreClase.toLowerCase()+"_Id'),$id);\n";
		output+="				}\n";
		output+="				$clausulas++;\n";
		output+="			}\n";
		output+="			$i++;\n";	
		output+="	  	}\n";
		
		output+="		if($clausulas>0){\n";
		output+="      		$this->db->delete($this->config->item('database_"+nombreClase.toLowerCase()+"_Tabla'));\n";
		output+="      		if($this->db->affected_rows()>0){\n";
		output+="           	return true;\n";
		output+="      		}else{\n";
		output+="        	   return false;\n";
		output+="      		}\n";
		output+="		}else{\n";
		output+="			return true;";
		output+="		}\n";
		output+="     }\n";
		return output;
	}
		
	/**
	 * Crear la función que establece los valores de la consulta estandar a la tabla
	 * @param nombreclase
	 * @param propiedades
	 * @return
	 */
	private static String GenerarSetValoresRow(String nombreclase, ArrayList<Propiedad> propiedades){
		String output="\n";
		/*
		 * $this->db->select($this->config->item('database_tabla_farmacias_id'));
		 */
		output+="     function SetValoresRow(){\n";
		output+="		  $this->db->select($this->config->item('database_"+nombreclase.toLowerCase()+"_Id'));\n";
		for(Propiedad propiedad : propiedades){
			if(!propiedad.getTipo().isSimple()){
				output+="         $this->db->select($this->config->item('database_"+nombreclase.toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"Id'));\n";	
				output+="         $this->db->select($this->config->item('database_"+nombreclase.toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"Nombre'));\n";	
			}else{
				output+="         $this->db->select($this->config->item('database_"+nombreclase.toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"'));\n";				
			}
		}		
		output+="     }\n";	
		return output;
	}
	
	
	/**
	 * Crear función que obtiene los valores de una fila que contiene toda la información de la tabla de la clase
	 * @param nombreclase
	 * @param propiedades
	 * @return
	 */
	private static String GenerarGetValoresRow(String nombreclase, ArrayList<Propiedad> propiedades){
		String output="\n";
		output+="     function GetValoresRow($row){\n";
		output+="         $obj['Id']=$row[$this->config->item('database_"+nombreclase.toLowerCase()+"_Id')];\n";
		for(Propiedad propiedad : propiedades){
			if(!propiedad.getTipo().isSimple()){
				output+="         $obj['"+propiedad.getNombre()+"Id'] = $row[$this->config->item('database_"+nombreclase.toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"Id')];\n";
				output+="         $obj['"+propiedad.getNombre()+"Nombre'] = $row[$this->config->item('database_"+nombreclase.toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"Nombre')];\n";
			}else{
				String letraInicial = propiedad.getNombre().substring(0, 1).toUpperCase();
				//String nombreFunction = propiedad.getNombre().replaceFirst(propiedad.getNombre().substring(0, 1), letraInicial);
				output+="         $obj['"+propiedad.getNombre()+"'] = $row[$this->config->item('database_"+nombreclase.toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"')];\n";
			}
		}
		output+="         return $obj;\n";
		output+="     }\n";	
		
		return output;
	}
	
	private static String GenerarGetAll(String nombreClase,ArrayList<Propiedad> propiedades){
		String output="\n";
		output+="	function getAll($limit=50, $offset=0, $campo=\"Id\", $ord=\"Asc\",$field=\"\", $busqueda=\"\"){\n";
		output+="		$this->SetValoresRow();\n";
		output+="		$this->db->from($this->config->item('database_"+nombreClase.toLowerCase()+"_Vista'));\n";
		output+="		$this->db->order_by($this->getNameColumn($campo), $ord);\n";
		output+="		$this->db->limit($limit, $offset);\n";
		output+="		if($field!=\"\"){\n";
		output+="			switch($field){\n";
		for(Propiedad p : propiedades){	//Campos =
		output+="				case \""+p.getNombre()+"\":\n";
			if(p.getTipo() instanceof Boolean || p.getTipo() instanceof Date){
		output+="					$this->db->where($this->getNameColumn($field), $busqueda);\n";;				
			}else{
		output+="					$this->db->like($this->getNameColumn($field), $busqueda);\n";;				
			}
		output+="					break;\n";
		output+="				\n";
		}
		output+="			}\n";
		output+="		}\n";
		output+="		$query = $this->db->get();\n";
		output+="		$objs = array();\n";
		output+="		if($query!=false && $query->num_rows()>0){\n";
		output+="			foreach($query->result_array() as $row){\n";
		output+="				$objs[] = $this->GetValoresRow($row);\n";
		output+="			}\n";
		output+="		}\n";
		output+="		return $objs;\n";
		output+="	}\n";
		return output;
	}

	private static String GenerarGetNameColumn(String nombreClase,ArrayList<Propiedad> propiedades){
		String output="\n";
		output+="	function getNameColumn($campo){\n";
		output+="		if($campo==='' || $campo === \"Id\"){\n";
		output+="			return $this->config->item('database_"+nombreClase.toLowerCase()+"_Id');\n";
		output+="		}\n";
		for(Propiedad p : propiedades){
			if(!p.getTipo().isSimple()){
				output+="		if($campo === \""+p.getNombre()+"Id\"){\n";
				output+="			return $this->config->item('database_"+nombreClase.toLowerCase()+"_"+p.getNombreBaseDatos().toLowerCase()+"Id');\n";
				output+="		}\n";
				output+="		if($campo === \""+p.getNombre()+"Nombre\"){\n";
				output+="			return $this->config->item('database_"+nombreClase.toLowerCase()+"_"+p.getNombreBaseDatos().toLowerCase()+"Nombre');\n";
				output+="		}\n";
				output+="		if($campo === \""+p.getNombre()+"\"){\n";
				output+="			return $this->config->item('database_"+nombreClase.toLowerCase()+"_"+p.getNombreBaseDatos().toLowerCase()+"');\n";
				output+="		}\n";
			}else{
				output+="		if($campo === \""+p.getNombre()+"\"){\n";
				output+="			return $this->config->item('database_"+nombreClase.toLowerCase()+"_"+p.getNombreBaseDatos().toLowerCase()+"');\n";
				output+="		}\n";				
			}

		}
		output+="		return $campo;\n";
		output+="	}\n";
		
		return output;
	}
}
