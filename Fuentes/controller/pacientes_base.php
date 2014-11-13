<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pacientes_base extends CI_Controller{
    private $CI;


	public function get(){
		$this->load->model('paciente');
		$this->load->library('servicepaciente');
		$recId = $_GET['recid'];
		$resultado=$this->servicepaciente->GetPacienteById($recId);
		$data['paciente'] = $resultado->getValue();
		$this->load->view('pages/Pacientes/getPacienteJson',$data);
	}

	public function getAll(){
		$this->load->model('paciente');
		$this->load->library('servicepaciente');
		$resultado=$this->servicepaciente->GetAll();
		$data['listaPaciente'] = $resultado->getValue();
		$this->load->view('pages/Pacientes/getListaPacienteJson',$data);
	}

	public function getListJson(){
		$this->load->model('paciente');
		$this->load->library('servicepaciente');
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
		$resultado=$this->servicepaciente->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaPaciente'] = $resultado->getValue();
		$this->load->view('pages/Pacientes/getListaPacienteJson',$data);
	}

	public function getEnum(){
		$this->load->model('paciente');
		$this->load->library('servicepaciente');
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
		$resultado=$this->servicepaciente->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaPaciente'] = $resultado->getValue();
		$this->load->view('pages/Pacientes/getEnumPaciente',$data);
	}

	public function nuevo(){
		$this->load->model('paciente');
		$this->load->library('servicepaciente');
		$this->load->library('form_validation');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$record=$_POST['record'];
 			$resultadoComprobaciones = $this->ComprobacionesFormNuevo();
			if($resultadoComprobaciones->isCorrecto()){
				if(isset($record['nombreNuevoPaciente'])&&$record['nombreNuevoPaciente']!=""){$nombre=$record['nombreNuevoPaciente'];}else{$nombre= "";}
				if(isset($record['apellidosNuevoPaciente'])&&$record['apellidosNuevoPaciente']!=""){$apellidos=$record['apellidosNuevoPaciente'];}else{$apellidos= "";}
				if(isset($record['descripcionNuevoPaciente'])&&$record['descripcionNuevoPaciente']!=""){$descripcion=$record['descripcionNuevoPaciente'];}else{$descripcion= "";}
				if(isset($record['empresaNuevoPaciente'])&&$record['empresaNuevoPaciente']!=""){$empresa=$record['empresaNuevoPaciente'];}else{$empresa= "";}
				if(isset($record['fechaNacimientoNuevoPaciente'])&&$record['fechaNacimientoNuevoPaciente']!=""){$fechaNacimiento=$record['fechaNacimientoNuevoPaciente'];}else{$fechaNacimiento= "";}
				if(isset($record['imagenNuevoPaciente'])&&$record['imagenNuevoPaciente']!=""){$imagen=$record['imagenNuevoPaciente'];}else{$imagen= "";}
				$resultado = $this->servicepaciente->Nuevo($nombre,$apellidos,$descripcion,$empresa,$fechaNacimiento,$imagen				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Pacientes/newPacienteResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Pacientes/newPacienteResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Pacientes/newPacienteResult',$data);
			return ;
		}
	}


	public function modificar(){
		$this->load->model('paciente');
		$this->load->library('servicepaciente');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		$this->load->library('form_validation');
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombrePaciente']!=""){$nombre=$record['nombrePaciente'];}else{$nombre= "";}
			if($record['apellidosPaciente']!=""){$apellidos=$record['apellidosPaciente'];}else{$apellidos= "";}
			if($record['descripcionPaciente']!=""){$descripcion=$record['descripcionPaciente'];}else{$descripcion= "";}
			if($record['empresaPaciente']!=""){$empresa=$record['empresaPaciente'];}else{$empresa= "";}
			if($record['fechaNacimientoPaciente']!=""){$fechaNacimiento=$record['fechaNacimientoPaciente'];}else{$fechaNacimiento= "";}
			if($record['imagenPaciente']!=""){$imagen=$record['imagenPaciente'];}else{$imagen= "";}
			$resultado = $this->servicepaciente->Modificar($recid,$nombre,$apellidos,$descripcion,$empresa,$fechaNacimiento,$imagen		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Pacientes/updatePacienteResult',$data);
	}

	public function eliminar(){
		$this->load->model('paciente');
		$this->load->library('servicepaciente');
		$this->load->library('form_validation');
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicepaciente->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Pacientes/deletePacienteResult',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Pacientes/formNuevoPaciente');
		}else{
			return "";
		}
	}
	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Pacientes/formModificarPaciente');
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
 	$this->form_validation->set_rules('record[nombreNuevoPaciente]','Nombre', 'required|min_length[3]|max_length[50]');
 	$this->form_validation->set_rules('record[apellidosNuevoPaciente]','Apellidos', 'required|min_length[3]|max_length[50]');
 	$this->form_validation->set_rules('record[descripcionNuevoPaciente]','Descripción', 'required');
 	$this->form_validation->set_rules('record[empresaNuevoPaciente]','Empresa', 'required');
 	$this->form_validation->set_rules('record[imagenNuevoPaciente]','Imagen', 'required');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
