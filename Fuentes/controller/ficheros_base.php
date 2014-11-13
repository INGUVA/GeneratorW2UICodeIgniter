<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ficheros_base extends CI_Controller{
    private $CI;


	public function get(){
		$this->load->model('fichero');
		$this->load->library('servicefichero');
		$recId = $_GET['recid'];
		$resultado=$this->servicefichero->GetFicheroById($recId);
		$data['fichero'] = $resultado->getValue();
		$this->load->view('pages/Ficheros/getFicheroJson',$data);
	}

	public function getAll(){
		$this->load->model('fichero');
		$this->load->library('servicefichero');
		$resultado=$this->servicefichero->GetAll();
		$data['listaFichero'] = $resultado->getValue();
		$this->load->view('pages/Ficheros/getListaFicheroJson',$data);
	}

	public function getListJson(){
		$this->load->model('fichero');
		$this->load->library('servicefichero');
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
		$resultado=$this->servicefichero->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaFichero'] = $resultado->getValue();
		$this->load->view('pages/Ficheros/getListaFicheroJson',$data);
	}

	public function getEnum(){
		$this->load->model('fichero');
		$this->load->library('servicefichero');
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
		$resultado=$this->servicefichero->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaFichero'] = $resultado->getValue();
		$this->load->view('pages/Ficheros/getEnumFichero',$data);
	}

	public function nuevo(){
		$this->load->model('fichero');
		$this->load->library('servicefichero');
		$this->load->library('form_validation');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$record=$_POST['record'];
 			$resultadoComprobaciones = $this->ComprobacionesFormNuevo();
			if($resultadoComprobaciones->isCorrecto()){
				if(isset($record['nombreNuevoFichero'])&&$record['nombreNuevoFichero']!=""){$nombre=$record['nombreNuevoFichero'];}else{$nombre= "";}
				if(isset($record['fechaCapturaNuevoFichero'])&&$record['fechaCapturaNuevoFichero']!=""){$fechaCaptura=$record['fechaCapturaNuevoFichero'];}else{$fechaCaptura= "";}
				if(isset($record['rutaNuevoFichero'])&&$record['rutaNuevoFichero']!=""){$ruta=$record['rutaNuevoFichero'];}else{$ruta= "";}
				if(isset($record['pacienteNuevoFichero'])&&$record['pacienteNuevoFichero']!=""){$paciente=$record['pacienteNuevoFichero'];}else{$paciente= "-1";}
				$resultado = $this->servicefichero->Nuevo($nombre,$fechaCaptura,$ruta,$paciente				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Ficheros/newFicheroResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Ficheros/newFicheroResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Ficheros/newFicheroResult',$data);
			return ;
		}
	}


	public function modificar(){
		$this->load->model('fichero');
		$this->load->library('servicefichero');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		$this->load->library('form_validation');
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombreFichero']!=""){$nombre=$record['nombreFichero'];}else{$nombre= "";}
			if($record['fechaCapturaFichero']!=""){$fechaCaptura=$record['fechaCapturaFichero'];}else{$fechaCaptura= "";}
			if($record['rutaFichero']!=""){$ruta=$record['rutaFichero'];}else{$ruta= "";}
			if($record['pacienteFichero']!=""){$paciente=$record['pacienteFichero'];}else{$paciente= "-1";}
			$resultado = $this->servicefichero->Modificar($recid,$nombre,$fechaCaptura,$ruta,$paciente		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Ficheros/updateFicheroResult',$data);
	}

	public function eliminar(){
		$this->load->model('fichero');
		$this->load->library('servicefichero');
		$this->load->library('form_validation');
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicefichero->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Ficheros/deleteFicheroResult',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Ficheros/formNuevoFichero');
		}else{
			return "";
		}
	}
	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Ficheros/formModificarFichero');
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
 	$this->form_validation->set_rules('record[nombreNuevoFichero]','Nombre', 'required|min_length[3]|max_length[50]');
 	$this->form_validation->set_rules('record[fechaCapturaNuevoFichero]','Fecha de captura', 'required');
 	$this->form_validation->set_rules('record[rutaNuevoFichero]','Imagen', 'required');
 	$this->form_validation->set_rules('record[pacienteNuevoFichero]','Paciente', 'required');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
