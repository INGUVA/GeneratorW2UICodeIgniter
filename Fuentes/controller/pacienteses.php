<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pacienteses extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->servicepacientes->GetPacientesById($recId);
		$data['pacientes'] = $resultado->getValue();
		$this->load->view('pages/Pacienteses/getPacientesJson',$data);
	}

	public function getAll(){
		$pacienteses=$this->servicepacientes->GetAll();
		var_dump($Pacienteses);
	}

	public function getListJson(){
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
		$resultado=$this->servicepacientes->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaPacientes'] = $resultado->getValue();
		$this->load->view('pages/Pacienteses/getListaPacientesJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Pacienteses/formNuevoPacientes');
		}else{
			return "";
		}
	}

	public function nuevo(){
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$record=$_POST['record'];
 			$resultadoComprobaciones = $this->ComprobacionesFormNuevo();
			if($resultadoComprobaciones->isCorrecto()){
				if(isset($record['nombreNuevoPacientes'])&&$record['nombreNuevoPacientes']!=""){$nombre=$record['nombreNuevoPacientes'];}else{$nombre= "";}
				if(isset($record['apellidosNuevoPacientes'])&&$record['apellidosNuevoPacientes']!=""){$apellidos=$record['apellidosNuevoPacientes'];}else{$apellidos= "";}
				if(isset($record['fechaNacimientoNuevoPacientes'])&&$record['fechaNacimientoNuevoPacientes']!=""){$fechaNacimiento=$record['fechaNacimientoNuevoPacientes'];}else{$fechaNacimiento= "";}
				$resultado = $this->servicepacientes->Nuevo($nombre,$apellidos,$fechaNacimiento				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Pacienteses/newPacientesResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Pacienteses/newPacientesResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Pacienteses/newPacientesResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Pacienteses/formModificarPacientes');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombrePacientes']!=""){$nombre=$record['nombrePacientes'];}else{$nombre= "";}
			if($record['apellidosPacientes']!=""){$apellidos=$record['apellidosPacientes'];}else{$apellidos= "";}
			if($record['fechaNacimientoPacientes']!=""){$fechaNacimiento=$record['fechaNacimientoPacientes'];}else{$fechaNacimiento= "";}
			$resultado = $this->servicepacientes->Modificar($recid,$nombre,$apellidos,$fechaNacimiento		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Pacienteses/updatePacientesResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicepacientes->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Pacienteses/deletePacientesResult',$data);
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
 	$this->form_validation->set_rules('record[nombreNuevoPacientes]','Nombre', 'required|min_length[3]|max_length[50]');
 	$this->form_validation->set_rules('record[apellidosNuevoPacientes]','Apellidos', 'required|min_length[3]|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>