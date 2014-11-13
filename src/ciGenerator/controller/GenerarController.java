package ciGenerator.controller;

import java.util.ArrayList;

import ciGenerator.Utils;
import ciGenerator.model.Propiedad;
import ciGenerator.model.tipos.Email;
import ciGenerator.model.tipos.TipoDatos;


public class GenerarController {

	/**
	 * @param args
	 */
	public static String Iniciar(String nombreClase,ArrayList<Propiedad> propiedades) {
	String output = "";
		
		output+="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
		output+="\n";
		output+="include_once 'application/controllers/"+Utils.ConvertirAPlurar(nombreClase)+"_base.php';\n";
		output+="class "+Utils.ConvertirAPlurar(nombreClase)+" extends "+Utils.ConvertirAPlurar(nombreClase)+"_base {\n";
		
		output+="}\n";
		return output;
	}
	
	/**
	 * @param args
	 */
	public static String IniciarBase(String nombreClase,ArrayList<Propiedad> propiedades) {
		String output = "";
		
		output+="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
		output+="\n";
		output+="class "+Utils.ConvertirAPlurar(nombreClase)+"_base extends CI_Controller{\n";
		output+="    private $CI;\n\n";
		
		/*CONSULTAS*/
		//Genero la función get
		output+=LoadGet(nombreClase);
		
		//Genero la funcion getAll
		output+=LoadGetAll(nombreClase);
		
		//Genero la función getListJson
		output+=LoadGetListJson(nombreClase);

		//Genero la función enum
		output+=LoadEnum(nombreClase);
		
		/*OPERACIONES*/
		//Genero la funciones para crear nuevos elementos: formNuevo y Nuevo
		output+=LoadNew(nombreClase, propiedades);
		
		//Genero la funciones para crear nuevos elementos: formNuevo y Nuevo
		output+=LoadUpdate(nombreClase, propiedades);
		
		//Genero la función delete
		output+=LoadDelete(nombreClase);
		
		//VISTAS
		output+=LoadVistas(nombreClase);
		
		//Genero las funciones de comprobaciones de crear, modificar, borrar
		output+=LoadComprobaciones(nombreClase, propiedades);
		
		output+="}\n";
		
		return output;
	}
	
	/**
	 * Devuelve una json del elemento
	 * @param nombreClase
	 * @return
	 */
	private static String LoadGet(String nombreClase){
		String output="\n";
		output+="	public function get(){\n";
		output+="		$this->load->model('"+nombreClase.toLowerCase()+"');\n";
		output+="		$this->load->library('service"+nombreClase.toLowerCase()+"');\n";
		output+="		$recId = $_GET['recid'];\n";
		output+="		$resultado=$this->service"+nombreClase.toLowerCase()+"->Get"+nombreClase+"ById($recId);\n";
		output+="		$data['"+nombreClase.toLowerCase()+"'] = $resultado->getValue();\n";
		output+="		$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/get"+nombreClase+"Json',$data);\n";
		output+="	}\n";
		return output;
	}
	
	/**
	 * Devuelve una lista json de todos los elementos
	 * @param nombreClase
	 * @return
	 */
	private static String LoadGetAll(String nombreClase){
		String output="\n";
		output+="	public function getAll(){\n";
		output+="		$this->load->model('"+nombreClase.toLowerCase()+"');\n";
		output+="		$this->load->library('service"+nombreClase.toLowerCase()+"');\n";
		output+="		$resultado=$this->service"+nombreClase.toLowerCase()+"->GetAll();\n";
		output+="		$data['lista"+nombreClase+"'] = $resultado->getValue();\n";
		output+="		$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/getLista"+nombreClase+"Json',$data);\n";
		output+="	}\n";
		return output;
	}

	/**
	 * Función para obtener la lista de elementos
	 * @param nombreClase
	 * @return
	 */
	private static String LoadGetListJson(String nombreClase){
		String output="\n";
		output+="	public function getListJson(){\n";
		output+="		$this->load->model('"+nombreClase.toLowerCase()+"');\n";
		output+="		$this->load->library('service"+nombreClase.toLowerCase()+"');\n";
		output+="		if(isset($_POST['limit'])){$limit=$_POST['limit'];}else{$limit=30;}\n";
		output+="		if(isset($_POST['offset'])){$offset=$_POST['offset'];}else{$offset=0;}\n";
		output+="		//Ordenación\n";
		output+="		if(isset($_POST['sort'])&&($_POST['sort']!=null)){\n";
		output+="			$sort = $_POST['sort'][0];\n";
		output+="			$campo = $sort['field'];\n";
		output+="			$direction = $sort['direction'];\n";
		output+="		}else{\n";
		output+="			$campo = \"\";\n";
		output+="			$direction = \"\";\n";
		output+="		}\n";
		
		output+="		//Busquedas\n";
		output+="		if(isset($_POST['search']) && $_POST['search']!=\"\"){\n";
		output+="			$search = $_POST['search'][0];\n";
		output+="			$field = $search['field'];\n";
		output+="			$busqueda = $search['value'];\n";	
		output+="		}else{\n";
		output+="			$field = \"\";\n";
		output+="			$busqueda = \"\";\n";
		output+="		}\n";
		output+="		$resultado=$this->service"+nombreClase.toLowerCase()+"->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);\n";
		output+="		$data['lista"+nombreClase+"'] = $resultado->getValue();\n";
		output+="		$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/getLista"+nombreClase+"Json',$data);\n";
		output+="	}\n";
		return output;
	}
	
	private static String LoadEnum(String nombreClase){
		String output="\n";
		output+="	public function getEnum(){\n";
		output+="		$this->load->model('"+nombreClase.toLowerCase()+"');\n";
		output+="		$this->load->library('service"+nombreClase.toLowerCase()+"');\n";
		output+="		if(isset($_POST['limit'])){$limit=$_POST['limit'];}else{$limit=30;}\n";
		output+="		if(isset($_POST['offset'])){$offset=$_POST['offset'];}else{$offset=0;}\n";
		output+="		//Ordenación\n";
		output+="		if(isset($_POST['sort'])&&($_POST['sort']!=null)){\n";
		output+="			$sort = $_POST['sort'][0];\n";
		output+="			$campo = $sort['field'];\n";
		output+="			$direction = $sort['direction'];\n";
		output+="		}else{\n";
		output+="			$campo = \"\";\n";
		output+="			$direction = \"\";\n";
		output+="		}\n";
		
		output+="		//Busquedas\n";
		output+="		if(isset($_POST['search']) && $_POST['search']!=\"\"){\n";
		output+="			$search = $_POST['search'][0];\n";
		output+="			$field = $search['field'];\n";
		output+="			$busqueda = $search['value'];\n";	
		output+="		}else{\n";
		output+="			$field = \"\";\n";
		output+="			$busqueda = \"\";\n";
		output+="		}\n";
		output+="		$resultado=$this->service"+nombreClase.toLowerCase()+"->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);\n";
		output+="		$data['lista"+nombreClase+"'] = $resultado->getValue();\n";
		output+="		$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/getEnum"+nombreClase+"',$data);\n";
		output+="	}\n";
		return output;
	}

	private static String LoadNew(String nombreClase, ArrayList<Propiedad> propiedades){
		String output="\n";
		output+="	public function nuevo(){\n";
		output+="		$this->load->model('"+nombreClase.toLowerCase()+"');\n";
		output+="		$this->load->library('service"+nombreClase.toLowerCase()+"');\n";
		output+="		$this->load->library('form_validation');\n";
		output+="		$actionPuedeCrear = $this->ComprobacionesNuevo();\n";
		output+="		if($actionPuedeCrear->isCorrecto()){\n";
		output+="			$record=$_POST['record'];\n";
		output+=" 			$resultadoComprobaciones = $this->ComprobacionesFormNuevo();\n";
		output+="			if($resultadoComprobaciones->isCorrecto()){\n";
		for(Propiedad p : propiedades){
		output+="				if(isset($record['"+p.getNombre()+"Nuevo"+nombreClase+"'])&&$record['"+p.getNombre()+"Nuevo"+nombreClase+"']!=\"\"){$"+p.getNombre()+"=$record['"+p.getNombre()+"Nuevo"+nombreClase+"'];}else{$"+p.getNombre()+"= \""+p.getTipo().getValorPorDefecto()+"\";}\n";
		}
		output+="				$resultado = $this->service"+nombreClase.toLowerCase()+"->Nuevo(";
		int i = 0;
		while(i<propiedades.size()){
			Propiedad p = propiedades.get(i);
			output+="$"+p.getNombre();
			i++;
			if(i<propiedades.size()){
				output+=",";
			}
		}
		output+="				);\n";
		output+="				$data['resultado'] = $resultado;\n";
		output+="				$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/new"+nombreClase+"Result',$data);\n";		
		output+="				return ;\n";
		output+="			}else{\n";
		output+="				$data['resultado'] = $resultadoComprobaciones;\n";
		output+="				$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/new"+nombreClase+"Result',$data);\n";		
		output+="				return ;\n";
		output+="			}\n";


		output+="		}else{\n";
		output+="			$resultado = $actionPuedeCrear;\n";
		output+="			$data['resultado'] = $resultado;\n";
		output+="			$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/new"+nombreClase+"Result',$data);\n";
		output+="			return ;\n";
		output+="		}\n";
		output+="	}\n";
		
		return output;
	}
	
	private static String LoadUpdate(String nombreClase, ArrayList<Propiedad> propiedades){
		String output="\n";
		
		output+="\n";
		output+="	public function modificar(){\n";
		output+="		$this->load->model('"+nombreClase.toLowerCase()+"');\n";
		output+="		$this->load->library('service"+nombreClase.toLowerCase()+"');\n";
		output+="		$actionPuedeModificar = $this->ComprobacionesModificar();\n";
		output+="		$this->load->library('form_validation');\n";
		output+="		if($actionPuedeModificar->isCorrecto()){\n";
		output+="			$record=$_POST['record'];\n";
		output+="			$recid = $_POST['recid'];\n";
		for(Propiedad p : propiedades){
		output+="			if($record['"+p.getNombre()+nombreClase+"']!=\"\"){$"+p.getNombre()+"=$record['"+p.getNombre()+nombreClase+"'];}else{$"+p.getNombre()+"= \""+p.getTipo().getValorPorDefecto()+"\";}\n";
		}
		
		output+="			$resultado = $this->service"+nombreClase.toLowerCase()+"->Modificar($recid,";
		int i = 0;
		while(i<propiedades.size()){
			Propiedad p = propiedades.get(i);
			output+="$"+p.getNombre();
			i++;
			if(i<propiedades.size()){
				output+=",";
			}
		}
		output+="		);\n";

		output+="		}else{\n";
		output+="			$resultado = $actionPuedeModificar;\n";
		output+="		}\n";
		output+="		$data['resultado'] = $resultado;\n";
		output+="		$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/update"+nombreClase+"Result',$data);\n";
		output+="	}\n";
		
		return output;
	}
	
	/**
	 * Función para borrar un elemento
	 * @param nombreClase
	 * @return
	 */
	private static String LoadDelete(String nombreClase){
		String output="\n";
		output+="	public function eliminar(){\n";
		output+="		$this->load->model('"+nombreClase.toLowerCase()+"');\n";
		output+="		$this->load->library('service"+nombreClase.toLowerCase()+"');\n";
		output+="		$this->load->library('form_validation');\n";
		output+="		$actionPuedeEliminar = $this->ComprobacionesEliminar();\n";
		output+="		$selected=$_POST['selected'];\n";
		output+="		if($actionPuedeEliminar->isCorrecto()){\n";
		output+="			$data['resultado']=$this->service"+nombreClase.toLowerCase()+"->EliminarById($selected);\n";
		output+="		}else{\n";
		output+="			$data['resultado'] = $actionPuedeEliminar();\n";
		output+="		}\n";
		output+="			$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/delete"+nombreClase+"Result',$data);\n";
		output+="	}\n";
		return output;
	}
	
	private static String LoadVistas(String nombreClase){
		String output="\n";
		output+="	public function formNuevo(){\n";
		output+="		header('Content-Type: text/html; charset=ISO-8859-1');\n";
		output+="		$actionPuedeCrear = $this->ComprobacionesNuevo();\n";
		output+="		if($actionPuedeCrear->isCorrecto()){\n";
		output+="			$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/formNuevo"+nombreClase+"');\n";
		output+="		}else{\n";
		output+="			return \"\";\n";
		output+="		}\n";
		output+="	}\n";
		
		output+="	public function formModificar(){\n";
		output+="		header('Content-Type: text/html; charset=ISO-8859-1');\n";
		output+="		$actionPuedeModificar = $this->ComprobacionesModificar();\n";
		output+="		if($actionPuedeModificar->isCorrecto()){\n";
		output+="			$this->load->view('pages/"+Utils.ConvertirAPlurar(nombreClase)+"/formModificar"+nombreClase+"');\n";
		output+="		}else{\n";
		output+="			return \"\";\n";
		output+="		}\n";
		output+="	}\n";
		return output;
	}
	
	private static String LoadComprobaciones(String nombreClase,ArrayList<Propiedad> propiedades){
		String output="\n";
		
		output+="	public function ComprobacionesNuevo(){\n";
		output+="		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);\n";
		output+="	}\n";
		output+="\n";
		output+="	public function ComprobacionesModificar(){\n";
		output+="		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);\n";
		output+="	}\n";
		output+="\n";
		output+="	public function ComprobacionesEliminar(){\n";
		output+="		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);\n";
		output+="	}\n";
		output+="\n";
		output+="	public function ComprobacionesListar(){\n";
		output+="		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);\n";
		output+="	}\n";

		output+="	public function ComprobacionesFormNuevo(){\n";
		for(Propiedad p : propiedades){
			String validaciones = "";
			validaciones+= p.isRequerido() ? "required": "";
			validaciones+= p.getHtmlMinLength()>0 ? "|min_length["+p.getHtmlMinLength()+"]" : "";
			validaciones+= p.getHtmlMaxLenght()>0 ? "|max_length["+p.getHtmlMaxLenght()+"]" : "";
			validaciones+= (p.getTipo() instanceof Email ? "|valid_email" : "");
			if(validaciones.length()>0){
		output+=" 	$this->form_validation->set_rules('record["+p.getNombre()+"Nuevo"+nombreClase+"]','"+p.getLabel()+"', '"+validaciones+"');\n";
			}
		}
		
		output+="		if ($this->form_validation->run() == FALSE){\n";
		output+="			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);\n";
		output+="		}else{\n";
		output+="			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);\n";
		output+="		}\n";		
		output+="	}\n";
		
		return output;
	}
}

