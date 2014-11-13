<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tratamientos_base extends CI_Controller{
    private $CI;


	public function get(){
		$this->load->model('tratamiento');
		$this->load->library('servicetratamiento');
		$recId = $_GET['recid'];
		$resultado=$this->servicetratamiento->GetTratamientoById($recId);
		$data['tratamiento'] = $resultado->getValue();
		$this->load->view('pages/Tratamientos/getTratamientoJson',$data);
	}

	public function getAll(){
		$this->load->model('tratamiento');
		$this->load->library('servicetratamiento');
		$resultado=$this->servicetratamiento->GetAll();
		$data['listaTratamiento'] = $resultado->getValue();
		$this->load->view('pages/Tratamientos/getListaTratamientoJson',$data);
	}

	public function getListJson(){
		$this->load->model('tratamiento');
		$this->load->library('servicetratamiento');
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
		$resultado=$this->servicetratamiento->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaTratamiento'] = $resultado->getValue();
		$this->load->view('pages/Tratamientos/getListaTratamientoJson',$data);
	}

	public function getEnum(){
		$this->load->model('tratamiento');
		$this->load->library('servicetratamiento');
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
		$resultado=$this->servicetratamiento->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaTratamiento'] = $resultado->getValue();
		$this->load->view('pages/Tratamientos/getEnumTratamiento',$data);
	}

	public function nuevo(){
		$this->load->model('tratamiento');
		$this->load->library('servicetratamiento');
		$this->load->library('form_validation');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$record=$_POST['record'];
 			$resultadoComprobaciones = $this->ComprobacionesFormNuevo();
			if($resultadoComprobaciones->isCorrecto()){
				if(isset($record['descripcionNuevoTratamiento'])&&$record['descripcionNuevoTratamiento']!=""){$descripcion=$record['descripcionNuevoTratamiento'];}else{$descripcion= "";}
				if(isset($record['fechaInicioNuevoTratamiento'])&&$record['fechaInicioNuevoTratamiento']!=""){$fechaInicio=$record['fechaInicioNuevoTratamiento'];}else{$fechaInicio= "";}
				if(isset($record['fechaFinalNuevoTratamiento'])&&$record['fechaFinalNuevoTratamiento']!=""){$fechaFinal=$record['fechaFinalNuevoTratamiento'];}else{$fechaFinal= "";}
				if(isset($record['pacienteNuevoTratamiento'])&&$record['pacienteNuevoTratamiento']!=""){$paciente=$record['pacienteNuevoTratamiento'];}else{$paciente= "-1";}
				if(isset($record['finalizadoNuevoTratamiento'])&&$record['finalizadoNuevoTratamiento']!=""){$finalizado=$record['finalizadoNuevoTratamiento'];}else{$finalizado= "false";}
				$resultado = $this->servicetratamiento->Nuevo($descripcion,$fechaInicio,$fechaFinal,$paciente,$finalizado				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Tratamientos/newTratamientoResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Tratamientos/newTratamientoResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Tratamientos/newTratamientoResult',$data);
			return ;
		}
	}


	public function modificar(){
		$this->load->model('tratamiento');
		$this->load->library('servicetratamiento');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		$this->load->library('form_validation');
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['descripcionTratamiento']!=""){$descripcion=$record['descripcionTratamiento'];}else{$descripcion= "";}
			if($record['fechaInicioTratamiento']!=""){$fechaInicio=$record['fechaInicioTratamiento'];}else{$fechaInicio= "";}
			if($record['fechaFinalTratamiento']!=""){$fechaFinal=$record['fechaFinalTratamiento'];}else{$fechaFinal= "";}
			if($record['pacienteTratamiento']!=""){$paciente=$record['pacienteTratamiento'];}else{$paciente= "-1";}
			if($record['finalizadoTratamiento']!=""){$finalizado=$record['finalizadoTratamiento'];}else{$finalizado= "false";}
			$resultado = $this->servicetratamiento->Modificar($recid,$descripcion,$fechaInicio,$fechaFinal,$paciente,$finalizado		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Tratamientos/updateTratamientoResult',$data);
	}

	public function eliminar(){
		$this->load->model('tratamiento');
		$this->load->library('servicetratamiento');
		$this->load->library('form_validation');
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicetratamiento->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Tratamientos/deleteTratamientoResult',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Tratamientos/formNuevoTratamiento');
		}else{
			return "";
		}
	}
	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Tratamientos/formModificarTratamiento');
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
 	$this->form_validation->set_rules('record[descripcionNuevoTratamiento]','Descripción', 'required|min_length[3]|max_length[50]');
 	$this->form_validation->set_rules('record[fechaInicioNuevoTratamiento]','Fecha de inicio', 'required');
 	$this->form_validation->set_rules('record[fechaFinalNuevoTratamiento]','Fecha de fin', 'required');
 	$this->form_validation->set_rules('record[pacienteNuevoTratamiento]','Paciente', 'required');
 	$this->form_validation->set_rules('record[finalizadoNuevoTratamiento]','Finalizado', 'required');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
