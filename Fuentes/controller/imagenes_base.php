<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imagenes_base extends CI_Controller{
    private $CI;


	public function get(){
		$this->load->model('imagen');
		$this->load->library('serviceimagen');
		$recId = $_GET['recid'];
		$resultado=$this->serviceimagen->GetImagenById($recId);
		$data['imagen'] = $resultado->getValue();
		$this->load->view('pages/Imagenes/getImagenJson',$data);
	}

	public function getAll(){
		$this->load->model('imagen');
		$this->load->library('serviceimagen');
		$resultado=$this->serviceimagen->GetAll();
		$data['listaImagen'] = $resultado->getValue();
		$this->load->view('pages/Imagenes/getListaImagenJson',$data);
	}

	public function getListJson(){
		$this->load->model('imagen');
		$this->load->library('serviceimagen');
		if(isset($_POST['limit'])){$limit=$_POST['limit'];}else{$limit=30;}
		if(isset($_POST['offset'])){$offset=$_POST['offset'];}else{$offset=0;}
		//Ordenación
		if(isset($_POST['sort'])&&($_POST['sort']!=null)){
			$sort = $_POST['sort'][0];
			$campo = $sort['field'];
			$direction = $sort['direction'];
		}else{
			$campo = "";
			$direction = "";
		}
		//Busquedas
		if(isset($_POST['search']) && $_POST['search']!=""){
			$search = $_POST['search'][0];
			$field = $search['field'];
			$busqueda = $search['value'];
		}else{
			$field = "";
			$busqueda = "";
		}
		$resultado=$this->serviceimagen->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaImagen'] = $resultado->getValue();
		$this->load->view('pages/Imagenes/getListaImagenJson',$data);
	}

	public function getEnum(){
		$this->load->model('imagen');
		$this->load->library('serviceimagen');
		if(isset($_POST['limit'])){$limit=$_POST['limit'];}else{$limit=30;}
		if(isset($_POST['offset'])){$offset=$_POST['offset'];}else{$offset=0;}
		//Ordenación
		if(isset($_POST['sort'])&&($_POST['sort']!=null)){
			$sort = $_POST['sort'][0];
			$campo = $sort['field'];
			$direction = $sort['direction'];
		}else{
			$campo = "";
			$direction = "";
		}
		//Busquedas
		if(isset($_POST['search']) && $_POST['search']!=""){
			$search = $_POST['search'][0];
			$field = $search['field'];
			$busqueda = $search['value'];
		}else{
			$field = "";
			$busqueda = "";
		}
		$resultado=$this->serviceimagen->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaImagen'] = $resultado->getValue();
		$this->load->view('pages/Imagenes/getEnumImagen',$data);
	}

	public function nuevo(){
		$this->load->model('imagen');
		$this->load->library('serviceimagen');
		$this->load->library('form_validation');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$record=$_POST['record'];
 			$resultadoComprobaciones = $this->ComprobacionesFormNuevo();
			if($resultadoComprobaciones->isCorrecto()){
				if(isset($record['nombreNuevoImagen'])&&$record['nombreNuevoImagen']!=""){$nombre=$record['nombreNuevoImagen'];}else{$nombre= "";}
				if(isset($record['fechaCapturaNuevoImagen'])&&$record['fechaCapturaNuevoImagen']!=""){$fechaCaptura=$record['fechaCapturaNuevoImagen'];}else{$fechaCaptura= "";}
				if(isset($record['rutaNuevoImagen'])&&$record['rutaNuevoImagen']!=""){$ruta=$record['rutaNuevoImagen'];}else{$ruta= "";}
				if(isset($record['pacienteNuevoImagen'])&&$record['pacienteNuevoImagen']!=""){$paciente=$record['pacienteNuevoImagen'];}else{$paciente= "-1";}
				$resultado = $this->serviceimagen->Nuevo($nombre,$fechaCaptura,$ruta,$paciente				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Imagenes/newImagenResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Imagenes/newImagenResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Imagenes/newImagenResult',$data);
			return ;
		}
	}


	public function modificar(){
		$this->load->model('imagen');
		$this->load->library('serviceimagen');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		$this->load->library('form_validation');
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombreImagen']!=""){$nombre=$record['nombreImagen'];}else{$nombre= "";}
			if($record['fechaCapturaImagen']!=""){$fechaCaptura=$record['fechaCapturaImagen'];}else{$fechaCaptura= "";}
			if($record['rutaImagen']!=""){$ruta=$record['rutaImagen'];}else{$ruta= "";}
			if($record['pacienteImagen']!=""){$paciente=$record['pacienteImagen'];}else{$paciente= "-1";}
			$resultado = $this->serviceimagen->Modificar($recid,$nombre,$fechaCaptura,$ruta,$paciente		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Imagenes/updateImagenResult',$data);
	}

	public function eliminar(){
		$this->load->model('imagen');
		$this->load->library('serviceimagen');
		$this->load->library('form_validation');
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->serviceimagen->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Imagenes/deleteImagenResult',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Imagenes/formNuevoImagen');
		}else{
			return "";
		}
	}
	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Imagenes/formModificarImagen');
		}else{
			return "";
		}
	}

	public function ComprobacionesNuevo(){
		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
	}

	public function ComprobacionesModificar(){
		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
	}

	public function ComprobacionesEliminar(){
		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
	}

	public function ComprobacionesListar(){
		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
	}
	public function ComprobacionesFormNuevo(){
 	$this->form_validation->set_rules('record[nombreNuevoImagen]','Nombre', 'required|min_length[3]|max_length[50]');
 	$this->form_validation->set_rules('record[fechaCapturaNuevoImagen]','Fecha de captura', 'required');
 	$this->form_validation->set_rules('record[rutaNuevoImagen]','Imagen', 'required');
 	$this->form_validation->set_rules('record[pacienteNuevoImagen]','Paciente', 'required');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
