<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videos_base extends CI_Controller{
    private $CI;


	public function get(){
		$this->load->model('video');
		$this->load->library('servicevideo');
		$recId = $_GET['recid'];
		$resultado=$this->servicevideo->GetVideoById($recId);
		$data['video'] = $resultado->getValue();
		$this->load->view('pages/Videos/getVideoJson',$data);
	}

	public function getAll(){
		$this->load->model('video');
		$this->load->library('servicevideo');
		$resultado=$this->servicevideo->GetAll();
		$data['listaVideo'] = $resultado->getValue();
		$this->load->view('pages/Videos/getListaVideoJson',$data);
	}

	public function getListJson(){
		$this->load->model('video');
		$this->load->library('servicevideo');
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
		$resultado=$this->servicevideo->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaVideo'] = $resultado->getValue();
		$this->load->view('pages/Videos/getListaVideoJson',$data);
	}

	public function getEnum(){
		$this->load->model('video');
		$this->load->library('servicevideo');
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
		$resultado=$this->servicevideo->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaVideo'] = $resultado->getValue();
		$this->load->view('pages/Videos/getEnumVideo',$data);
	}

	public function nuevo(){
		$this->load->model('video');
		$this->load->library('servicevideo');
		$this->load->library('form_validation');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$record=$_POST['record'];
 			$resultadoComprobaciones = $this->ComprobacionesFormNuevo();
			if($resultadoComprobaciones->isCorrecto()){
				if(isset($record['nombreNuevoVideo'])&&$record['nombreNuevoVideo']!=""){$nombre=$record['nombreNuevoVideo'];}else{$nombre= "";}
				if(isset($record['fechaCapturaNuevoVideo'])&&$record['fechaCapturaNuevoVideo']!=""){$fechaCaptura=$record['fechaCapturaNuevoVideo'];}else{$fechaCaptura= "";}
				if(isset($record['rutaNuevoVideo'])&&$record['rutaNuevoVideo']!=""){$ruta=$record['rutaNuevoVideo'];}else{$ruta= "";}
				if(isset($record['pacienteNuevoVideo'])&&$record['pacienteNuevoVideo']!=""){$paciente=$record['pacienteNuevoVideo'];}else{$paciente= "-1";}
				$resultado = $this->servicevideo->Nuevo($nombre,$fechaCaptura,$ruta,$paciente				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Videos/newVideoResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Videos/newVideoResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Videos/newVideoResult',$data);
			return ;
		}
	}


	public function modificar(){
		$this->load->model('video');
		$this->load->library('servicevideo');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		$this->load->library('form_validation');
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombreVideo']!=""){$nombre=$record['nombreVideo'];}else{$nombre= "";}
			if($record['fechaCapturaVideo']!=""){$fechaCaptura=$record['fechaCapturaVideo'];}else{$fechaCaptura= "";}
			if($record['rutaVideo']!=""){$ruta=$record['rutaVideo'];}else{$ruta= "";}
			if($record['pacienteVideo']!=""){$paciente=$record['pacienteVideo'];}else{$paciente= "-1";}
			$resultado = $this->servicevideo->Modificar($recid,$nombre,$fechaCaptura,$ruta,$paciente		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Videos/updateVideoResult',$data);
	}

	public function eliminar(){
		$this->load->model('video');
		$this->load->library('servicevideo');
		$this->load->library('form_validation');
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicevideo->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Videos/deleteVideoResult',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Videos/formNuevoVideo');
		}else{
			return "";
		}
	}
	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Videos/formModificarVideo');
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
 	$this->form_validation->set_rules('record[nombreNuevoVideo]','Nombre', 'required|min_length[3]|max_length[50]');
 	$this->form_validation->set_rules('record[fechaCapturaNuevoVideo]','Fecha de captura', 'required');
 	$this->form_validation->set_rules('record[rutaNuevoVideo]','Video', 'required');
 	$this->form_validation->set_rules('record[pacienteNuevoVideo]','Paciente', 'required');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
